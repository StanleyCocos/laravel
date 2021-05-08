<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller {

	public function index(Request $request) {
		$imei = $request->route('imei');
		$sql = "SELECT * FROM design_event order by id desc limit 0,20";
		if (isset($imei)) {
			$sql = "SELECT * FROM design_event where imei = '" . $imei . "' order by id desc limit 0,20";
			$list = DB::select($sql);
			if (count($list) == 0) {
				echo "没有查询到imei: " . $imei . " 的数据, 返回所有设备事件";
				$sql = "SELECT * FROM design_event order by id desc limit 0,20";
			}
		} else {
			echo "请添加imei";
		}
		$list = DB::select($sql);
		return view("event")->with('list', $list);
	}

	public function insert(Request $request) {
		$name = $request->input('name');
		$json = $request->header('user-agent');
		var_dump($json);
		$userAgent = $this->analyzeUserAgent($json);
		var_dump($userAgent);
		$data['platform'] = $userAgent['clients'];
		$data['version'] = $userAgent['version'];
		$data['name'] = $name;
		$data['imei'] = $userAgent['imei'];
		$sql = $this->createInsertSQL($data);
		$state = DB::insert($sql);
		if ($state) {
			return 'ok';
		} else {
			return $state;
		}
	}

	public function upload(Request $request) {
		if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
			$file = $request->file('upload');
			$destinationPath = 'storage/uploads/'; //public 文件夹下面建 storage/uploads 文件夹
			$extension = $file->getClientOriginalExtension();
			$fileName = md5(time() . rand(1, 1000)) . '.' . $extension;
			$file->move($destinationPath, $fileName);
			$filePath = asset($destinationPath . $fileName);
			//dd("文件路径：" . $filePath);
			$this->testAction($filePath);
		} else {
			dd('图片上传失败请重试.');
		}
	}

	private function createInsertSQL($data) {
		//构建"字段列表"和"值列表"字符串
		$fields = '';
		$values = '';
		foreach ($data as $key => $value) {
			$fields .= "$key,";
			$values .= "'$value',";
		}
		//去除结尾的逗号
		$fields = rtrim($fields, ',');
		$values = rtrim($values, ',');
		//构建插入的SQL语句：INSERT INTO news(title,content,hits) VALUES('标题','内容','30')
		return "INSERT INTO design_event($fields) VALUES($values)";
	}

	private function analyzeUserAgent($jsonStr) {
		$userAgent = explode(" ", $jsonStr);
		$header = array();
		foreach ($userAgent as $key => $value) {
			$item = explode('/', $value);
			$header[$item[0]] = $item[1];
		}
		return $header;
	}

}
