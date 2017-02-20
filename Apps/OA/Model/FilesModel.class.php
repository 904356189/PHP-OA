<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class FilesModel extends Model
{		
	protected $_validate = array(
		array('file_name', 'require', '文件名不能为空！'),
		array('open_scope', 'require', '公开范围不能为空！'),
		array('series_id', 'require', '文件类型不能为空！')
		
		);

	protected $_auto = array(
		array('update_time', 'getTime', 2, 'function'), //更新时写入当前时间戳
		);

	private function getTime(){
		return date('Y-m-d H:i:s');
	}

	// 生成文件上传数据
	// 返回数组
	// 错误则返回错误信息
	private function createUploadFile(){
		$upload = new \Think\Upload();
		$upload->rootPath = './';
		$upload->savePath = 'Public/Upload/';// 设置附件上传目录
		$upload->maxSize = 0;
		$info = $upload->upload();
		if($info) {// 上传成功获取信息
		  //$data['file_name'] = delFileExt($info['edoc']['name']);
		  $data['download_path'] = './'.$info['edoc']['savepath'].$info['edoc']['savename'];
		  $data['ext'] = $info['edoc']['ext'];
		  $data['size'] = $info['edoc']['size'];
		  $data['uploader'] = getCurrentUserId();
		  $data['file_name'] = I('file_name');
		  $data['summary'] = I('summary');
		  $data['series_id'] = I('series_id');
		  $data['open_scope'] = I('open_scope');
		  return $data;
		}
		else
		    return $upload->getError();
		
	}

	// 
	public function uploadFile($isRemind=false){
		$fileData = $this->createUploadFile();
		if(is_array($fileData)){
			$this->startTrans();
			if($this->create($fileData)){
				$id = $this->add();
				if(!$id){ //保存出错
					$this->rollback();
					return $this->getError();
				}
			}
			else{ // 验证数据错误
				$this->rollback();
				return $this->getError();
			}

			// 添加阅读提醒
			if($isRemind){
				$users = D('User');
				$members = $users->getStaff($fileData['open_scope'], false);
				$fu = M('FilesUser');
				$toReadData['file_id'] = $id;
				foreach ($members as $member) {
					$toReadData['user_id'] = $member['id'];
					$fu->data($toReadData)->add();
				}
			}

			$this->commit();
			return 1;
		}
		else
			return $fileData;
	}

	// 处理文件下载
	public function downloadFile($fileId){
		if($fileId){
			$fileInfo = $this->find($fileId);
			$fileName = iconv("utf-8","gb2312",$fileInfo['file_name'].'.'.$fileInfo['ext']);
			$filePath = $fileInfo['download_path'];
			$error = downloadFile($filePath, $fileName);
			if($error)
				return $error;
			else
				return 1;
		}
	}

	// 将文件标记为已读
	public function signFile($fileId, $readerId){
		$where['file_id'] = $fileId;
		$where['user_id'] = $readerId;
		$fu = M('FilesUser');
		$record = $fu->where($where)->find();
		if($record){
			if(!$record['is_read']){
				$record['is_read'] = 1;
				$record['update_time'] = date('Y-m-d H:i:s');
				$fu->save($record);
			}
			return 1;
		}
		else{
			return "该文件已标记为已读！";
		}

	}

	// 删除文件
	// 只有上传者或者管理员才能删除文件
	public function deleteFile($fileId, $deleterId){
		// 注意，删除文件时，应该删除对应的阅读提醒记录
		if($fileId){
			$file = $this->find($fileId);
			if($file['uploader']==$deleterId){
				// 删除硬盘上的文件
				if(file_exists($file['download_path']))
					unlink($file['download_path']);
				// 删除阅读记录
				$this->startTrans();
				$fu = M('FilesUser');
				$msg = $fu->where('file_id=$fileId')->delete();
				if(false===$msg){
					$this->rollback();
					return $fu->getError();
				}
				// 删除自身记录
				if($this->delete($fileId)!=1){
					$this->rollback();
					return $this->getError();
				}
				$this->commit();
				return 1;

			}
			else{
				// 文档不存在或者没有权限
				return "文档不存在或者没有权限删除！";
			}
		}
	}

	// 获取文档列表，倒序排列
	public function getFileList($openScope, $recordStart, $recordCount){
		if(is_string($openScope))
			$openScope = implode(',', $openScope);
		$where['open_scope'] = array('in', $openScope);
		return $this->where($where)
					->field('id, file_name, open_scope, uploader, summary, size, series')
					->limit($recordStart, $recordCount)
					->order('create_time desc')
					->select();
	}
	
}