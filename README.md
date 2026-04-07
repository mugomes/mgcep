# MGCEP

É uma biblioteca **leve e simples em PHP** para consulta de CEP utilizando a API pública do **ViaCEP**, com suporte a **cache local em arquivos** para melhorar desempenho e reduzir requisições externas.

Ideal para aplicações que precisam de **consultas rápidas de endereço**, com **baixo consumo de recursos** e **fácil integração**.

---

## ✨ Características

* Consulta de CEP via **ViaCEP**
* Cache local em arquivos (`.json`)
* Configuração de tempo de cache (TTL)
* API simples e direta
* Zero dependências externas
* Compatível com **PHP 8+**

---

## 📦 Instalação

### Manual

Copie a classe `MGCEP.php` para seu projeto e utilize via `require` ou autoload:

```php
composer require mugomes/mgcep;
```

---

## ⚙️ Configuração

Antes de utilizar, é recomendado configurar o diretório de cache:

```php
use MGCEP\MGCEP;

$cep = new MGCEP();
$cep->setCacheDir(__DIR__ . '/cache');
```

---

## 📮 Consulta de CEP

```php
$erro = $cep->getCEP('01001000');

if ($erro) {
    echo $erro;
} else {
    echo $cep->getLogradouro();
}
```

---

## 🧠 Métodos Públicos

### 📁 setCacheDir

Define o diretório onde os arquivos de cache serão armazenados.

```php
$cep->setCacheDir('/caminho/do/cache');
```

**Parâmetros:**

* `string $path` → Caminho do diretório
* `int $permission` → Permissão (padrão: `0777`)

---

### ⏱️ setCacheTTL

Define o tempo de vida do cache em segundos.

```php
$cep->setCacheTTL(3600); // 1 hora
```

---

### 🔍 getCEP

Realiza a consulta do CEP.

```php
$erro = $cep->getCEP('01001000');
```

**Retorno:**

* `false` → Sucesso
* `string` → Mensagem de erro

---

## 📍 Métodos de Dados

Após uma consulta bem-sucedida (`getCEP`), os dados podem ser acessados:

---

### 🏠 Endereço

```php
$cep->getLogradouro();
$cep->getComplemento();
$cep->getUnidade();
$cep->getBairro();
```

---

### 🌆 Localização

```php
$cep->getLocalidade();
$cep->getUF();
$cep->getEstado();
$cep->getRegiao();
```

---

### 🏛️ Informações adicionais

```php
$cep->getIBGE();
$cep->getGIA();
$cep->getDDD();
$cep->getSIAFI();
```

---

## 💡 Exemplo completo

```php
use MGCEP\MGCEP;

$cep = new MGCEP();
$cep->setCacheDir(__DIR__ . '/cache');
$cep->setCacheTTL(86400); // 1 dia

$erro = $cep->getCEP('01001000');

if ($erro) {
    echo "Erro: $erro";
    exit;
}

echo 'Rua: ' . $cep->getLogradouro() . PHP_EOL;
echo 'Bairro: ' . $cep->getBairro() . PHP_EOL;
echo 'Cidade: ' . $cep->getLocalidade() . PHP_EOL;
echo 'UF: ' . $cep->getUF() . PHP_EOL;
```

---

## ⚠️ Observações

* É necessário chamar `getCEP()` antes de acessar os métodos de dados
* O cache é baseado no **hash da URL**
* Arquivos expirados são removidos automaticamente
* Requer conexão com internet na primeira consulta

---

## 💙 Apoie

- GitHub: https://github.com/sponsors/mugomes
- More: https://mugomes.github.io/apoie.html

## 👤 Autor

**Murilo Gomes Julio**

🔗 [https://www.mugomes.com.br](https://www.mugomes.com.br)

📺 [https://youtube.com/@mugomesoficial](https://youtube.com/@mugomesoficial)

---

## License

The MGCEP is provided under:

[SPDX-License-Identifier: LGPL-2.1-only](https://github.com/mugomes/mgcep/blob/main/LICENSE)

Beign under the terms of the GNU Lesser General Public License version 2.1 only.

All contributions to the MGCEP are subject to this license.