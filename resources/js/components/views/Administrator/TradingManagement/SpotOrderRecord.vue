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
                            loading-text="Fetching Spot's list... Please wait"
                            :headers="tableSpotHeaders"
                            :items="tableSpots"
                            :search="tableSearch"
                        >
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title class="headline"
                                        >Spots</v-toolbar-title
                                    >
                                    <div class="flex-grow-1"></div>
                                    <!-- <v-btn
                                        small
                                        @click="formSpotDialog = true"
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
                                    tableSpots
                                        .map(function(x) {
                                            return x.id;
                                        })
                                        .indexOf(item.id) + 1
                                }}
                            </template> -->
                            <template v-slot:item.actions="{ item }">
                                <v-btn icon @click="editSpot(item)">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon @click="fetchAssets(item)">
                                    <v-icon>mdi-bitcoin</v-icon>
                                </v-btn>
                                <v-btn icon @click="addRecharge(item)">
                                    <v-icon>mdi-cash</v-icon>
                                </v-btn>
                                <v-btn icon @click="deleteSpot(item)">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
        <!-- <v-dialog v-model="formSpotDialog" max-width="800px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    {{ formSpotTitle }}
                </v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="
                                    formSpotErrors.user.username
                                "
                                v-model="
                                    editedSpotInformation.user.username
                                "
                                label="Username"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="
                                    editedSpotInformation.user.password
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
                                :error-messages="formSpotErrors.name"
                                v-model="editedSpotInformation.name"
                                label="Name"
                            />
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                type="text"
                                :error-messages="formSpotErrors.number"
                                v-model="editedSpotInformation.number"
                                label="Number"
                            />
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-select
                                :error-messages="formSpotErrors.status"
                                v-model="editedSpotInformation.status"
                                label="Status"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                type="text"
                                :error-messages="formSpotErrors.address"
                                v-model="editedSpotInformation.address"
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
                    <v-btn class="px-12" text @click="closeSpotForm"
                        >Cancel</v-btn
                    >
                    <v-btn class="px-12" @click="saveSpot" color="primary"
                        >Save</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog> -->

        <!-- For Editing -->
        <v-dialog v-model="formSpotDialog" max-width="800px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    {{ formSpotTitle }}
                </v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <!-- <v-col cols="12" md="6">
                            <v-text-field
                                v-model="
                                    editedSpotInformation.user.password
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
                                    formSpotErrors.user.username
                                "
                                v-model="
                                    editedSpotInformation.user.username
                                "
                                label="Username"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formSpotErrors.nickname"
                                v-model="editedSpotInformation.nickname"
                                label="Nickname"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formSpotErrors.number"
                                v-model="editedSpotInformation.mobile_number"
                                label="Mobile Number"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formSpotErrors.status"
                                v-model="editedSpotInformation.status"
                                :items="item_status"
                                item-text="name"
                                item-value="value"
                                label="Status"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formSpotErrors.address"
                                v-model="editedSpotInformation.referal_email"
                                label="Referal Email"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formSpotErrors.status"
                                v-model="editedSpotInformation.withdraw_transfer_status"
                                :items="item_withdraw_and_transfer"
                                item-text="name"
                                item-value="value"
                                label="Withdraw and Transfer Status"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formSpotErrors.status"
                                v-model="editedSpotInformation.membership_level"
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
                    <v-btn class="px-12" text @click="closeSpotForm"
                        >Cancel</v-btn
                    >
                    <v-btn class="px-12" @click="saveSpot" color="primary"
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
                                    editedSpotInformation.user.password
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
                    <v-btn class="px-12" text @click="closeSpotForm"
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
                    Spot Asset
                </v-card-title>
                <v-card-text>            
                        <v-container>
                            <v-data-table
                                :loading="tableLoading"
                                loading-text="Fetching Spot Asset's list... Please wait"
                                :headers="tableSpotAssetsHeaders"
                                :items="tableAssets"
                                :search="tableSearch"
                            >
                                <template v-slot:top>
                                    <v-toolbar flat>
                                        <v-toolbar-title class="headline"
                                            >Spots</v-toolbar-title
                                        >
                                        <div class="flex-grow-1"></div>
                                        <!-- <v-btn
                                            small
                                            @click="formSpotDialog = true"
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
                                        tableSpots
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
                    <v-btn class="px-12" text @click="closeSpotForm"
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
            tableSpots: [],
            itemCoins: [],
            tableAssets: [],
            formSpotDialog: false,
            formRechargeDialog: false,
            formSpotListDialog: false,
            formAssetsDialog: false,

            formSpotErrors: {
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

            tableSpotHeaders: [
                { text: "Serial Number", value: "id" },
                { text: "Role", value: "role" },
                { text: "UID", value: "id" },
                { text: "Email", value: "client.email" },
                { text: "Delegate Type", value: "delegate_type" },
                { text: "Trading Pair", value: "trading_pair" },
                { text: "state", value: "state" },
                { text: "Number of Orders", value: "number_of_order" },
                { text: "Order Unit Price", value: "unit_price" },
                { text: "Total Commission", value: "total_commission" },
                { text: "Final Price", value: "final_price" },
                { text: "Volume", value: "volume" },
                { text: "Turnover", value: "turnover" },
                { text: "Commission Time", value: "commission_time" },
                { text: "Last Modified", value: "date_modified" },
            ],

            tableSpotAssetsHeaders: [
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

            editedSpotIndex: -1,
            editedSpotInformation: {
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
            defaultSpotInformation: {
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
        formSpotTitle() {
            return this.editedSpotIndex === -1
                ? "New Spot"
                : "Edit Spot";
        }
    },

    mounted() {
        this.fetchSpots();
        this.fetchCoins();
    },

    methods: {

        fetchSpots() {
            this.tableLoading = true;
            this.componentOverlay = true;
            axios
                .get("/api/v1/order")
                .then(response => {
                    this.tableSpots = response.data.order;
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

        fetchAssets(customer)
        {
            this.editedSpotIndex = this.tableSpots.indexOf(customer);
            this.editedSpotInformation = Object.assign({}, customer);
            axios
                .get("/api/v1/wallets", {
                    params: {
                       client_id: this.editedSpotInformation.id
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

        saveSpot() {
            this.componentOverlay = true;
            if (this.editedSpotIndex > -1) {
                this.updateSpot();
            } else {
                this.createSpot();
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
                   client_id: this.editedSpotInformation.id,
                   coin_id: this.defaultRechargeInformation.coin,
                   transaction_type: this.defaultRechargeInformation.transaction_type,
                   included_in_performance: this.defaultRechargeInformation.included_in_performance,
                   recharge_amount: this.defaultRechargeInformation.amount,
                   account_type : this.editedSpotInformation.membership_level
                })
                .then(response => {
                    this.fetchSpots();
                    this.closeSpotForm();
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
                        this.formSpotErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        createSpot() {
            axios
                .post("/api/v1/clients", {
                    ..._.omit(this.editedSpotInformation, "user"),
                    ...this.editedSpotInformation.user,
                    password_confirmation: this.editedSpotInformation.user
                        .password
                })
                .then(response => {
                    this.fetchSpots();
                    this.closeSpotForm();
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
                        this.formSpotErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        editSpot(customer) {
            this.editedSpotIndex = this.tableSpots.indexOf(customer);
            this.editedSpotInformation = Object.assign({}, customer);
            this.formSpotDialog = true;
        },

        addRecharge(customer)
        {
            this.editedSpotIndex = this.tableSpots.indexOf(customer);
            this.editedSpotInformation = Object.assign({}, customer);
            this.formRechargeDialog = true;
        },

        updateSpot() {
            axios
                .put("/api/v1/clients/" + this.editedSpotInformation.id, {
                    ..._.omit(this.editedSpotInformation, "user"),
                    ...this.editedSpotInformation.user,
                    password_confirmation: this.editedSpotInformation.user
                        .password
                })
                .then(response => {
                    this.fetchSpots();
                    this.closeSpotForm();
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
                        this.formSpotErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        deleteSpot(customer) {
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
                            .delete("/api/v1/clients/" + customer.id)
                            .then(() => {
                                this.fetchSpots();
                                this.closeSpotForm();
                                swal.fire(
                                    "Deleted!",
                                    "Spot has been deleted.",
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

        closeSpotForm() {
            this.formSpotDialog = false;
            this.formRechargeDialog = false
            this.formAssetsDialog = false
            this.componentOverlay = false;
            this.deleteDialog = false;
            setTimeout(() => {
                this.formSpotErrors = {
                    name: null,
                    user: { username: null, password: null }
                };
                this.editedSpotInformation = Object.assign(
                    {},
                    this.defaultSpotInformation
                );
                this.editedSpotIndex = -1;
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
