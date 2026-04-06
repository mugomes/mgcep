<?php
// Copyright (C) 2026 Murilo Gomes Julio
// SPDX-License-Identifier: LGPL-2.1-only

// Site: https://www.mugomes.com.br

namespace MGCEP;

class MGCEP
{
    private string $cacheDir = '';
    private int $cacheTTL = 2592000; // 30 dias
    private array $dados = [];

    public function setCacheDir(string $path, int $permission = 0777)
    {
        if (!file_exists($path)) {
            mkdir($path, $permission, true);
        }

        $this->cacheDir = $path;
    }

    public function setCacheTTL(int $value)
    {
        $this->cacheTTL = $value;
    }

    private function setCache(string $key, array $data)
    {
        $filename = $this->cacheDir . '/' . md5($key) . '.json';
        file_put_contents($filename, json_encode($data), LOCK_EX);
    }

    private function getCache(string $key, string $ttl): ?array
    {
        $filename = $this->cacheDir . '/' . md5($key) . '.json';

        if (!file_exists($filename)) {
            return null;
        }

        if (time() - filemtime($filename) > $ttl) {
            unlink($filename);
            return null;
        }

        return json_decode(file_get_contents($filename), true);
    }

    private function getHTTPCache(string $url): array {
        $cached = $this->getCache($url, $this->cacheTTL);

        if ($cached !== null) {
            return [$cached, null, true];
        }

        $response = file_get_contents($url);

        if ($response === false) {
            return [null, 'Erro ao acessar API', false];
        }

        $data = json_decode($response, true);

        if ($data === null) {
            return [null, 'Erro ao decodificar JSON', false];
        }

        $this->setCache($url, $data);

        return [$data, null, false];
    }

    public function getCEP(string $cep):string|false {
        $cep = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            return 'CEP inválido';
        }

        $url = sprintf('https://viacep.com.br/ws/%s/json/', $cep);

        list($data, $erro) = $this->getHTTPCache($url);

        if ($erro) {
            return $erro;
        }

        if (!empty($data['erro'])) {
            return 'CEP não encontrado!';
        }


        $this->dados = $data;
        return false;
    }

    public function getLogradouro():string {
        return $this->dados['logradouro'];
    }

    public function getComplemento():string {
        return $this->dados['complemento'];
    }

    public function getUnidade():string {
        return $this->dados['unidade'];
    }

    public function getBairro():string {
        return $this->dados['bairro'];
    }

    public function getLocalidade():string {
        return $this->dados['localidade'];
    }

    public function getUF():string {
        return $this->dados['uf'];
    }

    public function getEstado():string {
        return $this->dados['estado'];
    }

    public function getRegiao():string {
        return $this->dados['regiao'];
    }

    public function getIBGE():int {
        return $this->dados['ibge'];
    }

    public function getGIA():int {
        return $this->dados['gia'];
    }

    public function getDDD():int {
        return $this->dados['ddd'];
    }

    public function getSIAFI():int {
        return $this->dados['siafi'];
    }
}
