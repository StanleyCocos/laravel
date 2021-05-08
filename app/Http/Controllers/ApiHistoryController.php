<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiHistoryController extends Controller {

	public function index(Request $request) {
		$imei = $request->route('imei');
		$sql = "SELECT * FROM api_history order by id desc limit 0,100";
		if (isset($imei)) {
			$sql = "SELECT * FROM api_history where imei = '" . $imei . "' order by id desc limit 0,100";
			$list = DB::select($sql);
			if (count($list) == 0) {
				echo "没有查询到imei: " . $imei . " 的数据, 返回所有设备事件";
				$sql = "SELECT * FROM api_history order by id desc limit 0,20";
			}
		} else {
			echo "请添加imei";
		}
		$list = DB::select($sql);
		return view("apiHistory")->with('list', $list);
	}

	public function insert(Request $request) {
		$data['api'] = $request->input('requestApi');
		$data['state'] = $request->input('requestState');
		$data['params'] = json_encode($request->input('params')); // implode(',', $request->input('params'));
		$data['result'] = json_encode($request->input('result'));
		$json = $request->header('user-agent');
		$userAgent = $this->analyzeUserAgent($json);
		$data['header'] = json_encode($request->header());
		$data['imei'] = $userAgent['imei'];
		$data['version'] = $userAgent['version'];
		$data['platform'] = $userAgent['clients'];
		$sql = $this->createInsertSQL($data);
		//echo $sql;
		$state = DB::insert($sql);
		if ($state) {
			return 'ok';
		} else {
			return $state;
			echo $state;
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
		return "INSERT INTO api_history($fields) VALUES($values)";
	}

	public function detail(Request $request) {
		$id = $request->route('id');
		$sql = "SELECT * FROM api_history where id = " . $id;
		$list = DB::select($sql);
		$detail = NULL;
		if (count($list) >= 1) {
			$detail = $list[0];
		}
		return view('apiHistoryDetail')->with('detail', $detail);
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

	private function toString($data) {
		$content = "";
		foreach ($data as $key => $value) {
			$content += $key . $values;
		}

	}

	private function unicodeDecode($unicode_str) {
		$json = '{"str":"' . $unicode_str . '"}';
		$arr = json_decode($json, true);
		if (empty($arr)) {
			return '';
		}

		return $arr['str'];
	}

}
