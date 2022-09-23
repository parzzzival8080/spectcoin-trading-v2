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
                                <v-btn icon @click="approveTransfer(item)">
                                    <v-icon color="primary">mdi-check</v-icon>
                                </v-btn>
                                <v-btn icon @click="declineTransfer(item)">
                                    <v-icon color="red">mdi-close</v-icon>
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

            tableTransferHeaders: [
                { text: "Serial Number", value: "id" },
                { text: "Contract Account", value: "coin.name" },
                { text: "Email", value: "client.email" },
                { text: "Swipe Direction", value: "draw_type" },
                { text: "State", value: "state" },
                { text: "Transfer amount", value: "transfer_amount" },
                { text: "Transfer Time", value: "transfer_time" },
                { text: "Review Time", value: "review_time" },
                { text: "Auditors", value: "auditor" },
                { text: "Notes", value: "notes" },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false,
                    
                }
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
                    this.tableTransfers = response.data.transfer;
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

        approveTransfer(transfer)
        {
            this.editedTransferIndex = this.tableTransfers.indexOf(transfer);
            this.editedTransferInformation = Object.assign({}, transfer);
            axios.post('/api/v1/update/transfers', {
                transfer_id: this.editedTransferInformation.id,
                client_id: this.editedTransferInformation.client_id,
                state: 'APPROVED'
            }).then(response => {
                this.fetchTransfers()
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
        },
        declineTransfer(transfer)
        {
            this.editedTransferIndex = this.tableTransfers.indexOf(transfer);
            this.editedTransferInformation = Object.assign({}, transfer);
            axios.post('/api/v1/update/transfers', {
                transfer_id: this.editedTransferInformation.id,
                client_id: this.editedTransferInformation.client_id,
                state: 'DECLINED'
            }).then(response => {
                this.fetchTransfers()
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
