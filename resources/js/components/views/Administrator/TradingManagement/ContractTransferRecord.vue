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
                            loading-text="Fetching Transfer's list... Please wait"
                            :headers="tableTransferHeaders"
                            :items="tableTransfers"
                            :search="tableSearch"
                        >
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title class="headline"
                                        >Transfers</v-toolbar-title
                                    >
                                    <div class="flex-grow-1"></div>
                                    <!-- <v-btn
                                        small
                                        @click="formTransferDialog = true"
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
                                    tableTransfers
                                        .map(function(x) {
                                            return x.id;
                                        })
                                        .indexOf(item.id) + 1
                                }}
                            </template> -->
                            <template v-slot:item.actions="{ item }">
                                <v-btn icon @click="editTransfer(item)">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon @click="fetchAssets(item)">
                                    <v-icon>mdi-bitcoin</v-icon>
                                </v-btn>
                                <v-btn icon @click="addRecharge(item)">
                                    <v-icon>mdi-cash</v-icon>
                                </v-btn>
                                <v-btn icon @click="deleteTransfer(item)">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
        <!-- <v-dialog v-model="formTransferDialog" max-width="800px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    {{ formTransferTitle }}
                </v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="
                                    formTransferErrors.user.username
                                "
                                v-model="
                                    editedTransferInformation.user.username
                                "
                                label="Username"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="
                                    editedTransferInformation.user.password
                                "
                                label="Password"
                                id="password"
                                name="password"
                                prepend-icon="fa-lock"
                                :append-icon="
                                    visible ? 'mdi-eye-off' : 'mdi-eye'
                                "
                                @click:append="visible = !visible"
                                :rules="rules.passwordRules"
                                :type="visible ? 'text' : 'password'"
                                @keydown.enter="login()"
                            />
                        </v-col>
                    </v-row>
                    <v-row justify="center">
                        <v-col cols="12" md="4">
                            <v-text-field
                                type="text"
                                :error-messages="formTransferErrors.name"
                                v-model="editedTransferInformation.name"
                                label="Name"
                            />
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                type="text"
                                :error-messages="formTransferErrors.number"
                                v-model="editedTransferInformation.number"
                                label="Number"
                            />
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-select
                                :error-messages="formTransferErrors.status"
                                v-model="editedTransferInformation.status"
                                label="Status"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                type="text"
                                :error-messages="formTransferErrors.address"
                                v-model="editedTransferInformation.address"
                                label="Address"
                            />
                        </v-col>
                    </v-row>
                    <v-row
                        ><v-col cols="12">
                            
                    </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="px-12" text @click="closeTransferForm"
                        >Cancel</v-btn
                    >
                    <v-btn class="px-12" @click="saveTransfer" color="primary"
                        >Save</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog> -->

        <!-- For Editing -->
        <v-dialog v-model="formTransferDialog" max-width="800px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    {{ formTransferTitle }}
                </v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <!-- <v-col cols="12" md="6">
                            <v-text-field
                                v-model="
                                    editedTransferInformation.user.password
                                "
                                label="Password"
                                id="password"
                                name="password"
                                prepend-icon="fa-lock"
                                :append-icon="
                                    visible ? 'mdi-eye-off' : 'mdi-eye'
                                "
                                @click:append="visible = !visible"
                                :rules="rules.passwordRules"
                                :type="visible ? 'text' : 'password'"
                            />
                        </v-col> -->
                    </v-row>
                    
                    <v-row justify="center">
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="
                                    formTransferErrors.user.username
                                "
                                v-model="
                                    editedTransferInformation.user.username
                                "
                                label="Username"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formTransferErrors.nickname"
                                v-model="editedTransferInformation.nickname"
                                label="Nickname"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formTransferErrors.number"
                                v-model="editedTransferInformation.mobile_number"
                                label="Mobile Number"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formTransferErrors.status"
                                v-model="editedTransferInformation.status"
                                :items="item_status"
                                item-text="name"
                                item-value="value"
                                label="Status"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formTransferErrors.address"
                                v-model="editedTransferInformation.referal_email"
                                label="Referal Email"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formTransferErrors.status"
                                v-model="editedTransferInformation.withdraw_transfer_status"
                                :items="item_withdraw_and_transfer"
                                item-text="name"
                                item-value="value"
                                label="Withdraw and Transfer Status"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formTransferErrors.status"
                                v-model="editedTransferInformation.membership_level"
                                :items="item_membership_level"
                                item-text="name"
                                item-value="value"
                                
                                label="Membership Level"
                            />
                        </v-col>
                    </v-row>
                    <v-row
                        ><v-col cols="12">
                            
                    </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="px-12" text @click="closeTransferForm"
                        >Cancel</v-btn
                    >
                    <v-btn class="px-12" @click="saveTransfer" color="primary"
                        >Save</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="formRechargeDialog" max-width="800px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    Recharge
                </v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <!-- <v-col cols="12" md="6">
                            <v-text-field
                                v-model="
                                    editedTransferInformation.user.password
                                "
                                label="Password"
                                id="password"
                                name="password"
                                prepend-icon="fa-lock"
                                :append-icon="
                                    visible ? 'mdi-eye-off' : 'mdi-eye'
                                "
                                @click:append="visible = !visible"
                                :rules="rules.passwordRules"
                                :type="visible ? 'text' : 'password'"
                            />
                        </v-col> -->
                    </v-row>
                    
                    <v-row justify="center">

                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formRechargeErrors.coin"
                                v-model="defaultRechargeInformation.coin"
                                :items="itemCoins"
                                item-text="name"
                                item-value="id"
                                label="Select Coin"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formRechargeErrors.included_in_performance"
                                v-model="defaultRechargeInformation.transaction_type"
                                :items="item_transaction_type"
                                item-text="name"
                                item-value="value"
                                label="Transaction Type"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formRechargeErrors.included_in_performance"
                                v-model="defaultRechargeInformation.included_in_performance"
                                :items="item_ip"
                                item-text="name"
                                item-value="value"
                                label="Included in Performance"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="number"
                                :error-messages="formRechargeErrors.amountRule"
                                :rules="rules.amountRules"
                                v-model="defaultRechargeInformation.amount"
                                label="Amount"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            />
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="px-12" text @click="closeTransferForm"
                        >Cancel</v-btn
                    >
                    <v-btn class="px-12" @click="saveRecharge" color="primary"
                        >Save</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="formAssetsDialog" max-width="1200px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    Transfer Asset
                </v-card-title>
                <v-card-text>            
                        <v-container>
                            <v-data-table
                                :loading="tableLoading"
                                loading-text="Fetching Transfer Asset's list... Please wait"
                                :headers="tableTransferAssetsHeaders"
                                :items="tableAssets"
                                :search="tableSearch"
                            >
                                <template v-slot:top>
                                    <v-toolbar flat>
                                        <v-toolbar-title class="headline"
                                            >Transfers</v-toolbar-title
                                        >
                                        <div class="flex-grow-1"></div>
                                        <!-- <v-btn
                                            small
                                            @click="formTransferDialog = true"
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
                                        tableTransfers
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
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="px-12" text @click="closeTransferForm"
                        >Close</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
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
            tableTransfers: [],
            itemCoins: [],
            tableAssets: [],
            formTransferDialog: false,
            formRechargeDialog: false,
            formTransferListDialog: false,
            formAssetsDialog: false,

            formTransferErrors: {
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

            tableTransferHeaders: [
                { text: "Serial Number", value: "id" },
                { text: "Contract Account", value: "role" },
                { text: "Email", value: "email" },
                { text: "UID", value: "delegate_type" },
                { text: "Swipe Direction", value: "trading_pair" },
                { text: "state", value: "state" },
                { text: "Transfer amount", value: "number_of_orders" },
                { text: "State", value: "" },
                { text: "Transfer Time", value: "client_referal_id" },
                { text: "Review Time", value: "withdraw_transfer_status" },
                { text: "Auditors", value: "volume" },
                { text: "Review Notes", value: "" },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false,
                    
                }
            ],

            tableTransferAssetsHeaders: [
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

            editedTransferIndex: -1,
            editedTransferInformation: {
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
            defaultTransferInformation: {
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
        formTransferTitle() {
            return this.editedTransferIndex === -1
                ? "New Transfer"
                : "Edit Transfer";
        }
    },

    mounted() {
        this.fetchTransfers();
        this.fetchCoins();
    },

    methods: {

        fetchTransfers() {
            this.tableLoading = true;
            this.componentOverlay = true;
            axios
                .get("/api/v1/transfers")
                .then(response => {
                    this.tableTransfers = response.data.transfers;
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

        fetchAssets(transfer)
        {
            this.editedTransferIndex = this.tableTransfers.indexOf(transfer);
            this.editedTransferInformation = Object.assign({}, transfer);
            axios
                .get("/api/v1/wallets", {
                    params: {
                       client_id: this.editedTransferInformation.id
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

        saveTransfer() {
            this.componentOverlay = true;
            if (this.editedTransferIndex > -1) {
                this.updateTransfer();
            } else {
                this.createTransfer();
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
                   client_id: this.editedTransferInformation.id,
                   coin_id: this.defaultRechargeInformation.coin,
                   transaction_type: this.defaultRechargeInformation.transaction_type,
                   included_in_performance: this.defaultRechargeInformation.included_in_performance,
                   recharge_amount: this.defaultRechargeInformation.amount,
                   account_type : this.editedTransferInformation.membership_level
                })
                .then(response => {
                    this.fetchTransfers();
                    this.closeTransferForm();
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
                        this.formTransferErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        createTransfer() {
            axios
                .post("/api/v1/transfers", {
                    ..._.omit(this.editedTransferInformation, "user"),
                    ...this.editedTransferInformation.user,
                    password_confirmation: this.editedTransferInformation.user
                        .password
                })
                .then(response => {
                    this.fetchTransfers();
                    this.closeTransferForm();
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
                        this.formTransferErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        editTransfer(transfer) {
            this.editedTransferIndex = this.tableTransfers.indexOf(transfer);
            this.editedTransferInformation = Object.assign({}, transfer);
            this.formTransferDialog = true;
        },

        addRecharge(transfer)
        {
            this.editedTransferIndex = this.tableTransfers.indexOf(transfer);
            this.editedTransferInformation = Object.assign({}, transfer);
            this.formRechargeDialog = true;
        },

        updateTransfer() {
            axios
                .put("/api/v1/transfers/" + this.editedTransferInformation.id, {
                    ..._.omit(this.editedTransferInformation, "user"),
                    ...this.editedTransferInformation.user,
                    password_confirmation: this.editedTransferInformation.user
                        .password
                })
                .then(response => {
                    this.fetchTransfers();
                    this.closeTransferForm();
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
                        this.formTransferErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        deleteTransfer(transfer) {
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
                            .delete("/api/v1/transfers/" + transfer.id)
                            .then(() => {
                                this.fetchTransfers();
                                this.closeTransferForm();
                                swal.fire(
                                    "Deleted!",
                                    "Transfer has been deleted.",
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

        closeTransferForm() {
            this.formTransferDialog = false;
            this.formRechargeDialog = false
            this.formAssetsDialog = false
            this.componentOverlay = false;
            this.deleteDialog = false;
            setTimeout(() => {
                this.formTransferErrors = {
                    name: null,
                    user: { username: null, password: null }
                };
                this.editedTransferInformation = Object.assign(
                    {},
                    this.defaultTransferInformation
                );
                this.editedTransferIndex = -1;
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
