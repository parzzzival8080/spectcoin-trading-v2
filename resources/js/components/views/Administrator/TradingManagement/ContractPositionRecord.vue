<template>
    <v-container fluid>
        <!-- <v-overlay :value="componentOverlay">
            <v-progress-circular
                :size="100"
                :width="5"
                indeterminate
            ></v-progress-circular>
        </v-overlay> -->
        <v-row justify-center wrap>
            <v-col md10>
                <v-card class="elevation-9 ma-4">
                    <v-container>
                        <v-data-table
                            :loading="tableLoading"
                            loading-text="Fetching Future's list... Please wait"
                            :headers="tableFutureHeaders"
                            :items="tableFutures"
                            :search="tableSearch"
                        >
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title class="headline"
                                        >Futures</v-toolbar-title
                                    >
                                    <div class="flex-grow-1"></div>
                                    <!-- <v-btn
                                        small
                                        @click="formFutureDialog = true"
                                        color="primary"
                                    >
                                        <v-icon small left
                                            >mdi-plus-circle</v-icon
                                        >
                                        Add Offline 
                                    </v-btn> -->
                                </v-toolbar>
                            </template>
                            <!-- <template v-slot:item.id="{ item }">
                                {{
                                    tableFutures
                                        .map(function(x) {
                                            return x.id;
                                        })
                                        .indexOf(item.id) + 1
                                }}
                            </template> -->
                            <template v-slot:item.actions="{ item }">
                                
                            </template>
                        </v-data-table>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            componentOverlay: false,
            // profileId: sessionStorage.getItem("profile-id"),
            tableLoading: true,
            tableSearch: null,
            searchInput: "",
            visible: false,
            tableFutures: [],
            itemCoins: [],
            tableAssets: [],
            formFutureDialog: false,
            formRechargeDialog: false,
            formFutureListDialog: false,
            formAssetsDialog: false,
            timer: null,
            timerTable: null,

            formFutureErrors: {
                name: null,
                address: null,
                number: null,
                user: { username: null, password: null },
            },

            formRechargeErrors: {
                coin: null, 
                account_type: null,
                included_in_performance: null,
                amount: null,
            },

            item_status: [
                {'name': 'USABLE', 'value' : 'USABLE'},
                {'name': 'FREEZE_ACCOUNT', 'value' : 'FREEZE_ACCOUNT'},
            ],

            item_withdraw_and_transfer: [
                {'name': 'ALLOWED', 'value' : 'ALLOWED'},
                {'name': 'NOT_ALLOWED', 'value' : 'NOT_ALLOWED'},
            ],

            item_coin: [
                {'name': 'USDT', 'value' : 'USDT'},
            ],

            item_transaction_type: [
                {'name': 'RECHARGE', 'value' : 'RECHARGE'},
                {'name': 'DEDUCTION', 'value' : 'DEDUCTION'},
            ],

            item_ip: [
                {'name': 'YES', 'value' : 'YES'},
                {'name': 'NO', 'value' : 'NO'},
            ],

            item_membership_level: [
                {'name': 'VIP1', 'value' : 'VIP1'},
                {'name': 'VIP2', 'value' : 'VIP2'},
                {'name': 'VIP3', 'value' : 'VIP3'},
                {'name': 'VIP4', 'value' : 'VIP4'},
                {'name': 'VIP5', 'value' : 'VIP5'},
                {'name': 'VIP6', 'value' : 'VIP6'},
                {'name': 'VIP7', 'value' : 'VIP7'},
                {'name': 'VIP8', 'value' : 'VIP8'},
                {'name': 'VIP9', 'value' : 'VIP9'},
                {'name': 'VIP10', 'value' : 'VIP10'},
            ],

            tableFutureHeaders: [
                { text: "Serial Number", value: "id" },
                { text: "Trading Pair", value: "" },
                { text: "Email", value: "client.email" },
                { text: "Role", value: "client.role" },
                { text: "Type", value: "trading_pair" },
                { text: "Opening Price", value: "opening_price" },
                { text: "Leverage", value: "leverage" },
                { text: "Estimated Force Parity", value: "estimated_force_parity" },
                { text: "Margin", value: "margin" },
                { text: "Open Interest", value: "open_interest" },
                { text: "Current Price", value: "current_price" },
                { text: "Manual Closing is not Allowed", value: "manual_closing_allowed" },
                { text: "Reached Stop Loss Difference", value: "reached_stop_loss_difference" },
                { text: "Total Assets", value: "total_asset" },
                { text: "Reach take Profit Difference", value: "reached_take_profit_difference" },
                { text: "Income", value: "income" },
                { text: "Rate of return", value: "rate_of_return" },

                {
                    text: "Actions",
                    value: "actions",
                    sortable: false,
                    
                }
            ],

            tableFutureAssetsHeaders: [
                { text: "Role", value: "client.role" },
                { text: "Email", value: "client.email" },
                { text: "UID", value: "client.id" },
                { text: "Currency", value: "coin.name" },
                { text: "Balance", value: "wallet_balance" },
                { text: "Restricted Withdraw Amount", value: "restricted_with_withdraw_amount" },
                { text: "Freeze", value: "freeze" },
                { text: "Credit", value: "credit" },
                { text: "Billing", value: "billing" },
                { text: "Wallet Address", value: "address" },
                

            ],

            editedFutureIndex: -1,
            editedFutureInformation: {
                name: null,
                email: null,
                mobile_number:null,
                email: null,
                nickname: null,
                role: null,
                withdraw_transfer_status: null,
                membership_level: null,
                user: { username: null, password: null },

            },
            defaultFutureInformation: {
                name: null,
                email: null,
                mobile_number:null,
                referal_email: null,
                nickname: null,
                role: null,
                withdraw_and_transfer_status: null,
                membership_level: null,
                user: { username: null, password: null },
            },

            defaultRechargeInformation: {
                account_type: null,
                item_status: null,
                item_account_type: null,
                coin: null,
                transaction_type: null,
            },

            //Google Maps Variables

            rules: {
                required: [
                    v => !!v || "Field is required",
                    v =>
                        (!!v && v.length <= 255) ||
                        " Field should not be more than 255 characters"
                ],
                emailRules: [
                    v => !!v || "E-mail is required",
                    v =>
                        /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                        "E-mail must be valid",
                    v =>
                        (!!v && v.length <= 255) ||
                        "E-mail must not be more than 255 characters"
                ],
                mobileRules: [
                    v => !!v || "Mobile Number is required",
                    v =>
                        (!!v && v.length >= 10) ||
                        "Mobile Number must be 11 characters",
                    v =>
                        (!!v && v.length < 11) ||
                        "Mobile Number must not be more than 11 characters"
                ],

                amountRules: [
                    v => !!v || "Amount is required",
                ],

               
                passwordRules: [
                    v => !!v || "Password is required",
                    v =>
                        (!!v && v.length >= 8) ||
                        "Password must be more than 8 characters"
                ]
            }
        };
    },

    computed: {
        formFutureTitle() {
            return this.editedFutureIndex === -1
                ? "New Future"
                : "Edit Future";
        }
    },

    mounted() {
        this.fetchFutures();
        this.fetchCoins();
    },

    created()
    {
        this.timer = setInterval(this.updateOngoingFuture, 3000)
        this.timerTable = setInterval(this.fetchFutures, 3000)
    },
    

    methods: {

        updateOngoingFuture()
        {
            axios.get('/api/v1/ongoing/future')
            .then(response => {

            })
        },

        fetchFutures() {
            this.tableLoading = true;
            this.componentOverlay = true;
            axios
                .get("/api/v1/future-records")
                .then(response => {
                    this.tableFutures = response.data.future;
                    console.log(this.tableFutures)
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.componentOverlay = false;
                    this.tableLoading = false;
                });
        },

        fetchCoins() {
            axios
                .get("/api/v1/coins")
                .then(response => {
                    this.itemCoins = response.data.coins;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.componentOverlay = false;
                    this.tableLoading = false;
                });
        },

        fetchAssets(future)
        {
            this.editedFutureIndex = this.tableFutures.indexOf(future);
            this.editedFutureInformation = Object.assign({}, future);
            axios
                .get("/api/v1/wallets", {
                    params: {
                       client_id: this.editedFutureInformation.id
                    }
                })
                .then(response => {
                    this.tableAssets = response.data.assets
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.componentOverlay = false;
                    this.tableLoading = false;
                });

                this.formAssetsDialog = true
        },

        saveFuture() {
            this.componentOverlay = true;
            if (this.editedFutureIndex > -1) {
                this.updateFuture();
            } else {
                this.createFuture();
            }
        },

        saveRecharge()
        {
            this.componentOverlay = true;
            this.createDeposit();
        },

        createDeposit()
        {
            axios
                .post("/api/v1/deposits", {
                   client_id: this.editedFutureInformation.id,
                   coin_id: this.defaultRechargeInformation.coin,
                   transaction_type: this.defaultRechargeInformation.transaction_type,
                   included_in_performance: this.defaultRechargeInformation.included_in_performance,
                   recharge_amount: this.defaultRechargeInformation.amount,
                   account_type : this.editedFutureInformation.membership_level
                })
                .then(response => {
                    this.fetchFutures();
                    this.closeFutureForm();
                    swal.fire({
                        position: "top-end",
                        toast: true,
                        type: "success",
                        icon: "success",
                        text: "Deposit Successfully Requested",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(error => {
                    this.componentOverlay = false;

                    if (error.response.status == 422) {
                        this.formFutureErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        createFuture() {
            axios
                .post("/api/v1/futures", {
                    ..._.omit(this.editedFutureInformation, "user"),
                    ...this.editedFutureInformation.user,
                    password_confirmation: this.editedFutureInformation.user
                        .password
                })
                .then(response => {
                    this.fetchFutures();
                    this.closeFutureForm();
                    swal.fire({
                        position: "top-end",
                        toast: true,
                        type: "success",
                        icon: "success",
                        text: "Successfully Created",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(error => {
                    this.componentOverlay = false;

                    if (error.response.status == 422) {
                        this.formFutureErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        editFuture(future) {
            this.editedFutureIndex = this.tableFutures.indexOf(future);
            this.editedFutureInformation = Object.assign({}, future);
            this.formFutureDialog = true;
        },

        addRecharge(future)
        {
            this.editedFutureIndex = this.tableFutures.indexOf(future);
            this.editedFutureInformation = Object.assign({}, future);
            this.formRechargeDialog = true;
        },

        updateFuture() {
            axios
                .put("/api/v1/futures/" + this.editedFutureInformation.id, {
                    ..._.omit(this.editedFutureInformation, "user"),
                    ...this.editedFutureInformation.user,
                    password_confirmation: this.editedFutureInformation.user
                        .password
                })
                .then(response => {
                    this.fetchFutures();
                    this.closeFutureForm();
                    swal.fire({
                        position: "top-end",
                        toast: true,
                        type: "success",
                        icon: "success",
                        text: "Successfully Updated",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(error => {
                    this.componentOverlay = false;

                    if (error.response.status == 422) {
                        this.formFutureErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        deleteFuture(future) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            })
                .then(result => {
                    if (result.value) {
                        axios
                            .delete("/api/v1/futures/" + future.id)
                            .then(() => {
                                this.fetchFutures();
                                this.closeFutureForm();
                                swal.fire(
                                    "Deleted!",
                                    "Future has been deleted.",
                                    "success"
                                );
                            })
                            .catch(error => {
                                swal.fire(
                                    "Failed!",
                                    "There was something wrong.",
                                    "warning"
                                );
                                this.error = response.data.errors;
                                if (
                                    error.response.data.message ==
                                    "Unauthenticated."
                                ) {
                                    sessionStorage.clear();
                                    this.$router.push("/login");
                                }
                                return;
                            });
                    }
                })
                .catch(() => {
                    swal("Failed!", "There was something wrong.", "warning");
                });
        },

        closeFutureForm() {
            this.formFutureDialog = false;
            this.formRechargeDialog = false
            this.formAssetsDialog = false
            this.componentOverlay = false;
            this.deleteDialog = false;
            setTimeout(() => {
                this.formFutureErrors = {
                    name: null,
                    user: { username: null, password: null }
                };
                this.editedFutureInformation = Object.assign(
                    {},
                    this.defaultFutureInformation
                );
                this.editedFutureIndex = -1;
            }, 500);
        },
    },
    beforeRouteEnter (to, from, next) {
        if(sessionStorage.getItem('user-type') != "ADMINISTRATOR"){
          return next('/')
        }
        next();
    }
};

</script>
