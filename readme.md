# 💰 Moneylender

**Moneylender** é uma aplicação SaaS desenvolvida para auxiliar no controle de empréstimos de forma prática e segura. Ideal para pessoas físicas, pequenas empresas ou instituições que desejam gerenciar clientes, fornecedores e operações de crédito com eficiência.

---

## 🚀 Funcionalidades

- ✅ Cadastro e gerenciamento de **clientes**
- ✅ Cadastro e gerenciamento de **fornecedores**
- 💵 **Registro de empréstimos** (à vista ou parcelado)
- 💳 **Pagamentos de parcelas**
- 📄 **Geração de recibos de empréstimos**
- 📊 **Relatórios financeiros**

---

## 🧰 Tecnologias Utilizadas

- **PHP** (backend)
- **MySQL** (banco de dados relacional)
- **JavaScript**, **HTML**, **CSS** (frontend)
- **Docker** (ambiente containerizado para fácil setup)

---

## 🐳 Executando com Docker

Antes de iniciar, certifique-se de ter o Docker instalado no seu sistema. Veja os tutoriais oficiais:

- [Docker no Windows](https://docs.docker.com/desktop/install/windows-install/)
- [Docker no Linux](https://docs.docker.com/engine/install/)
- [Docker no Mac](https://docs.docker.com/desktop/install/mac-install/)

```bash
# Clone o repositório
git clone https://github.com/Franciscojr08/moneylender.git
cd moneylender

# Construa e inicie os containers
docker compose up -d

# Acesse o sistema em:
http://localhost
