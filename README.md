# Teste técnico para Magento Software Specialist

Consiste em criar um sistema de assinaturas utilizando o Magento, onde o Usuário, ao comprar um Produto, seja relacionado à uma Assinatura através de uma Inscrição com data de expiração.

## Infra

Para o desenvolvimento local foi utilizado o projeto: https://github.com/markshust/docker-magento Para executar o projeto faça o seguinte passo-a-passo:

### 1) Download the Docker Compose template:

```bash
curl -s https://raw.githubusercontent.com/markshust/docker-magento/master/lib/template | bash
```

### 2) Clonando o projeto na página src:

```bash
git clone git@github.com:cyberwork/magento_specialist_test.git src
```

### 3) Iniciando alguns containers, copiando os arquivos e reiniciando os containers:

```bash
bin/start --no-dev
bin/copytocontainer --all ## Initial copy will take a few minutes...
```

### 4) Importando o Banco de Dados

```bash
bin/mysql < src/magento.sql
```

**Os acessos ao banco de dados do container mysql estão em env/db.env**

### 5) Executando o setup upgrade

```bash
bin/magento setup:upgrade
```

### 6) Importando as configurações, adicionando entrada de DNS e Reiniciando os containers

```bash
bin/magento app:config:import
bin/setup-domain magento.test
bin/restart
```

### 7) Acesse magento.local

## Observaçoes

#### Acesso admin

```bash
https://magento.test/admin
username: john.smith
password: password123
```

# Extras

- O período padrão de assinaturas são 30 dias após a assinatura.
- Criei um Grid usando a UI de grids do Magento para exibir todas as assinaturas do Banco de Dados, ela está em Sales => Suno Signatures
- É possível habilitar e desabilitar as assinaturas
- Também é possível Habilita/Desabilitar e Excluir as Assinaturas em massa.
- Vídeo do funcionamento do módulo: https://www.loom.com/share/1e5f910325e04b9fa8a865700dd6b9e8
