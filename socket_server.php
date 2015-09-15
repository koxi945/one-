<?php

class WebSocketServer {

	private $laravelKernel;

	private $serv;

	private $listenIp = '192.168.199.128';

	private $listenPort = 9502;

	public function initSwooleWebSocketServer() {
		$this->serv = new swoole_websocket_server($this->listenIp, $this->listenPort);
		$this->onOpen()->onMessage()->onClose();
		$this->serv->start();
		return $this;
	}

	public function initL5() {
		require __DIR__.'/bootstrap/autoload.php';
		$app = require_once __DIR__.'/bootstrap/app.php';
		return $this;
	}

	private function handleL5($data) {
		if( ! isset($data['controller'], $data['action'], $data['params'])) return $this->error();
		$controller = ucfirst(strtolower($data['controller']));
		$action = strtolower($data['action']);
		$params = $data['params'];
		$touchClass = '\\App\\Services\\Home\Soket\\'.$controller;
		if(class_exists($touchClass)) {
			$classObject = new $touchClass();
			if(method_exists($classObject, $action)) return $classObject->$action($params);
		}
		return $this->error();
	}

	private function onOpen() {
		$this->serv->on('Open', function($server, $req) {
		    echo "connection open: ".$req->fd."\n";
		});
		return $this;
	}

	private function onMessage() {
		$this->serv->on('Message', function($server, $frame) {
		    $data = json_decode($frame->data, TRUE);
		    $server->push($frame->fd, json_encode($this->handleL5($data)));
		});
		return $this;
	}

	private function onClose() {
		$this->serv->on('close', function($server, $fd) {
		    echo "client {$fd} closed\n";
		});
		return $this;
	}

	private function error() {
		return ['success' => false, 'message' => 'not touch'];
	}
}

$obj = new WebSocketServer();
$obj->initL5()->initSwooleWebSocketServer();