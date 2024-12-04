import axios from "axios";

export default {
    name: "Dashboard",
    props: {
        logout: Function 
    },
    data() {
        return {
            loading: true,
            accounts: [],
            visibleBalances: {},
            message: "",
            showCreateAccountForm: false,
            newAccount: {
                type: "poupanca", // Tipo padrão
            },
        };
    },
    computed: {
        // Verifica se é possível criar mais contas (limite de 3)
        canCreateAccount() {
            return this.accounts.length < 3;
        },
    },
    methods: {
        toggleBalance(accountId) {
            // Alterna o estado visível de saldo de uma conta
            if (this.visibleBalances[accountId] !== undefined) {
                this.visibleBalances[accountId] = !this.visibleBalances[accountId];
            } else {
                this.visibleBalances[accountId] = true;
            }
        },
        async fetchAccounts() {
            this.loading = true;
            try {
                const response = await axios.get("/api/accounts", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                    },
                });
                this.accounts = response.data.accounts || [];
                this.visibleBalances = this.accounts.reduce((acc, account) => {
                    acc[account.id] = false;
                    return acc;
                }, {});
            } catch (error) {
                this.message = "Erro ao carregar contas.";
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async createAccount() {
            try {
                const response = await axios.post(
                    "/api/accounts",
                    { type: this.newAccount.type },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                        },
                    }
                );
                console.log(response)
                this.message = "Conta criada com sucesso!";
                this.showCreateAccountForm = false;
                this.fetchAccounts(); // Atualiza as contas
            } catch (error) {
                if (error.response && error.response.data && error.response.data.message) {
                    this.message = error.response.data.message; 
                } else {
                    this.message = "Erro ao criar conta.";
                }
                console.error(error);
            }
        },
        async deposit(accountId) {
            const amount = prompt("Digite o valor para depósito:");
            if (amount && !isNaN(amount)) {
                try {
                    const response = await axios.post(
                        `/api/accounts/${accountId}/deposit`,
                        { amount: parseFloat(amount) },
                        {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                            },
                        }
                    );
                    this.message = response.data.message;
                    this.fetchAccounts(); // Atualiza as contas após o depósito
                } catch (error) {
                    this.message = "Erro ao realizar depósito.";
                    console.error(error);
                }
            }
        },
        async checkBalance(accountId) {
            try {
                const response = await axios.get(
                    `/api/accounts/${accountId}/balance`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                        },
                    }
                );
                alert(
                    `O saldo da conta ${response.data.account.type} é R$ ${response.data.account.balance.toFixed(
                        2
                    )}`
                );
            } catch (error) {
                this.message = "Erro ao consultar saldo.";
                console.error(error);
            }
        },
    },
    mounted() {
        this.fetchAccounts();
    },
};