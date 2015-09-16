<?php

class WebSocketServer {

    private $receiveData;

    private $serv;

    private $listenIp = '192.168.199.128';

    private $listenPort = 9502;

    public function initSwooleWebSocketServer() {
        $this->serv = new swoole_websocket_server($this->listenIp, $this->listenPort);
        $this->onOpen()->onMessage()->onClose();
        $this->serv->start();
        return $this;
    }

    public function initVender() {
        require __DIR__.'/vendor/autoload.php';
        return $this;
    }

    private function handle($fd, $data, $onType = '') {
        if( ! isset($data['controller'], $data['action'], $data['params'])) return $this->jsonResponse('params not set');
        $controller = ucfirst(strtolower($data['controller']));
        $action = strtolower($data['action']);
        $params = $data['params'];
        $touchClass = '\\App\\Services\\Home\Soket\\'.$controller;
        if(class_exists($touchClass)) {
            $classObject = new $touchClass();
            if(method_exists($classObject, $action)) return $classObject->$action($fd, $params, $onType);
        }
        return $this->jsonResponse('not touch action');
    }

    private function onOpen() {
        $this->serv->on('Open', function($server, $req) {
            //echo "connection open: ".$req->fd."\n";
        });
        return $this;
    }

    private function onMessage() {
        $this->serv->on('Message', function($server, $frame) {
            $data = $this->receiveData = json_decode($frame->data, TRUE);
            $server->push($frame->fd, $this->jsonResponse($this->handle($frame->fd, $data, 'onMessage'), true));
        });
        return $this;
    }

    private function onClose() {
        $this->serv->on('close', function($server, $fd) {
            $result = $this->handle($fd, $this->receiveData, 'onClose');
            if( ! isset($result['fdList']) or ! is_array($result['fdList'])) return false;
            foreach($result['fdList'] as $fdkey) {
                $server->push($fdkey, $this->jsonResponse($result['nums'], true));
            }
        });
        return $this;
    }

    private function jsonResponse($message, $status = false) {
        $status = $status ? 'success' : 'error';
        $json = array('result' => $status, 'message' => $message);
        return json_encode($json);
    }
}

define('SWOOLE_SOCKET_BASE_PATH', __DIR__);
$obj = new WebSocketServer();
$obj->initVender()->initSwooleWebSocketServer();