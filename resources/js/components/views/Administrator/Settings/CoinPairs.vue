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
                            loading-text="Fetching Coin's list... Please wait"
                            :headers="tableCoinHeaders"
                            :items="tableCoins"
                            :search="tableSearch"
                        >
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title class="headline">Coin Pairs</v-toolbar-title
                                    >
                                    <div class="flex-grow-1"></div>
                        
                                    <v-row >
                                        <v-col  cols="12" md="6">
                                            
                                        </v-col>
                                        <v-col cols="12" md="6" style="margin-right:10px">
                                            <v-select
                                            v-model="filter_coin_pair"
                                            @change="fetchCoinpairs()"
                                            :items="filterType"
                                            item-text="name"
                                            item-value="id"
                                            label="Pair Type"
                                            width="20px"
                                        />
                                        </v-col>
                                        
                                    </v-row>
                                    
                                    <v-btn
                                        small
                                        @click="formCoinDialog = true"
                                        color="primary"
                                    >
                                        <v-icon small left
                                            >mdi-plus-circle</v-icon
                                        >
                                        Add Coin Pair
                                    </v-btn>
                                </v-toolbar>
                            </template>
                            <!-- <template v-slot:item.id="{ item }">
                                {{
                                    tableCoins
                                        .map(function(x) {
                                            return x.id;
                                        })
                                        .indexOf(item.id) + 1
                                }}
                            </template> -->
                            <template v-slot:item.actions="{ item }">
                                <v-btn icon @click="editCoin(item)">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon @click="updateChart(item)">
                                    <v-icon>mdi-chart-areaspline</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="formCoinDialog" max-width="800px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    {{ formCoinTitle }}
                </v-card-title>
                <v-card-text>
                    <v-row justify="center">
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.coin_pair_type"
                                v-model="editedCoinPairInformation.coin_pair_type"
                                :items="pairType"
                                item-text="name"
                                item-value="id"
                                label="Pair Type"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.partition"
                                v-model="editedCoinPairInformation.partition"
                                :items="itemPartition"
                                item-text="name"
                                item-value="id"
                                label="Select Partition"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.coin_id"
                                v-model="editedCoinPairInformation.coin_id"
                                :items="itemCoins"
                                item-text="name"
                                item-value="id"
                                label="Select Coin"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.coin_pair_id"
                                v-model="editedCoinPairInformation.coin_pair_id"
                                :items="itemCoins"
                                item-text="name"
                                item-value="id"
                                label="Select Coin Pair"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.open_for_trade_status"
                                v-model="editedCoinPairInformation.open_for_trade_status"
                                :items="items"
                                item-text="name"
                                item-value="id"
                                label="Allow Trade"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.currency_transaction_status"
                                v-model="editedCoinPairInformation.currency_transaction_status"
                                :items="items"
                                item-text="name"
                                item-value="id"
                                label="Allow Currency Transaction"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.contract_transaction_status"
                                v-model="editedCoinPairInformation.contract_transaction_status"
                                :items="items"
                                item-text="name"
                                item-value="id"
                                label="Allow Contract Transactions"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.automatic_collection_status"
                                v-model="editedCoinPairInformation.automatic_collection_status"
                                :items="items"
                                item-text="name"
                                item-value="id"
                                label="Allow Automatic Collection"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.mainstream_currency_status"
                                v-model="editedCoinPairInformation.mainstream_currency_status"
                                :items="items"
                                item-text="name"
                                item-value="id"
                                label="Mainstream Currency Status"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                :error-messages="formCoinPairErrors.withdrawal_status"
                                v-model="editedCoinPairInformation.withdrawal_status"
                                :items="items"
                                item-text="name"
                                item-value="id"
                                label="Allow coin to Withdraw"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formCoinPairErrors.contract_delivery_cycle"
                                v-model="editedCoinPairInformation.contract_delivery_cycle"
                                label="Contract Delivery Cycle"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                type="text"
                                :error-messages="formCoinPairErrors.queue_number"
                                v-model="editedCoinPairInformation.queue_number"
                                label="Queue Number"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                type="number"
                                :error-messages="formCoinPairErrors.minimum_withdrawal_amount"
                                v-model="editedCoinPairInformation.minimum_withdrawal_amount"
                                label="Minimum Withdraw Amount"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                type="number"
                                :error-messages="formCoinPairErrors.withdrawal_fee"
                                v-model="editedCoinPairInformation.withdrawal_fee"
                                label="Withdrawal Fee"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            />
                        </v-col>


                        <v-col cols="12" md="6">
                            <v-text-field
                                type="number"
                                :error-messages="formCoinPairErrors.account_balance_limit"
                                v-model="editedCoinPairInformation.account_balance_limit"
                                label="Account Balance Limit"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            />
                        </v-col>


                        <v-col cols="12" md="6">
                            <v-text-field
                                type="number"
                                :error-messages="formCoinPairErrors.account_limit_required"
                                v-model="editedCoinPairInformation.account_limit_required"
                                label="Account Balance Required"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            />
                        </v-col>


                        <v-col cols="12" md="6">
                            <v-text-field
                                type="number"
                                :error-messages="formCoinPairErrors.minimum_sell"
                                v-model="editedCoinPairInformation.minimum_sell"
                                label="Minimum Sell"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            />
                        </v-col>             
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="px-12" text @click="closeCoinForm"
                        >Cancel</v-btn
                    >
                    <v-btn class="px-12" @click="saveCoin" color="primary"
                        >Save</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- For Editing -->

        <v-dialog v-model="formChartDialog" max-width="1200px" persistent>
            <v-card>
                <v-overlay :value="componentOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    Coin Asset
                </v-card-title>
                <v-card-text>            
                        <v-container>
                            <v-row justify-center>
                                <v-col cols="12" md="6">
                                    <trading-vue  :width="this.width" :height="this.height" :data="this.$data" title-txt="BTCUSD"></trading-vue>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="date"
                                            label="Date"
                                        />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="open"
                                            label="Open"
                                        />
                                        
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="high"
                                            label="High"
                                        />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="low"
                                            label="Low"
                                        />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="close"
                                            label="Close"
                                        />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="volume"
                                            label="Volume"
                                        />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="price_range_from"
                                            label="Ranging From"
                                        />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                            type="text"
                                            :error-messages="formCoinPairErrors.queue_number"
                                            v-model="price_range_to"
                                            label="To"
                                        />
                                        </v-col>

                                    </v-row>
                                </v-col>
                            </v-row>
                            
                        </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="px-12" @click="addToChart()" color="primary"
                        >Save</v-btn
                    >
                    <v-btn class="px-12" text @click="closeCoinForm"
                        >Close</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-btn @click="getAccountInfo()">Try</v-btn>
    </v-container>
</template>

<script>
import axios from 'axios';
import TradingVue from 'trading-vue-js'

export default {
    components: { TradingVue },
    data() {
        return {

            /** Charts */
            chartData: [],
            ohlcv: [
                [ 1551128400000, 33,  37.1, 14,  14,  196 ],
                [ 1551132000000, 13.7, 30, 6.6,  30,  206 ],
            ],
            width: 500,
            height: 500,
            componentOverlay: false,
            // profileId: sessionStorage.getItem("profile-id"),
            tableLoading: true,
            tableSearch: null,
            searchInput: "",
            visible: false,
            tableCoins: [],
            itemCoins: [],
            tableAssets: [],
            formCoinDialog: false,
            formRechargeDialog: false,
            formCoinListDialog: false,
            formChartDialog: false,
                partition: null,
                coin_id: null, 
                coin_pair_id: null,
                open_for_trade_status: null,
                currency_transaction_status: null,
                contract_transaction_status: null,
                automatic_collection_status: null,
                mainstream_currency_status: null,
                withdrawal_status: null,
                contract_delivery_cycle: null,
                queue_number: null,
                minimum_withdrawal_amount: null,
                withdrawal_fee: null,
                account_balance_limit: null, 
                account_limit_required: null,
                minimum_sell: null,
                turnover: null,
                date: null,
                open: null,
                high:null,
                low: null,
                close: null,
                volume: null,
                price_range_from: null, 
                price_range_to: null,
                chartTick: [],
                filter_coin_pair: "ALL",

            


            formCoinPairErrors: {
                
            },

            defaultCoinPairInformation: {
                partition: null,
                coin_id: null, 
                coin_pair_id: null,
                open_for_trade_status: null,
                currency_transaction_status: null,
                contract_transaction_status: null,
                automatic_collection_status: null,
                mainstream_currency_status: null,
                withdrawal_status: null,
                contract_delivery_cycle: null,
                queue_number: null,
                minimum_withdrawal_amount: null,
                withdrawal_fee: null,
                account_balance_limit: null, 
                account_limit_required: null,
                minimum_sell: null,
                turnover: null,
                date: null,
                open: null,
                high:null,
                low: null,
                close: null,
                volume: null,
                price_range_from: null, 
                price_range_to: null,
            },

            filterType: [
                {'name': 'ALL', 'value' : 'ALL'},
                {'name': 'OPEN', 'value' : 'OPEN'},
                {'name': 'INNO', 'value' : 'INNO'},
                {'name': 'INN', 'value' : 'INN'},
                {'name': 'AI', 'value' : 'AI'},
                {'name': 'MAIN', 'value' : 'MAIN'},
            ],

            pairType: [
                {'name': 'OPEN', 'value' : 'OPEN'},
                {'name': 'INNO', 'value' : 'INNO'},
                {'name': 'INN', 'value' : 'INN'},
                {'name': 'AI', 'value' : 'AI'},
                {'name': 'MAIN', 'value' : 'MAIN'},
            ],

            item_status: [
                {'name': 'USABLE', 'value' : 'USABLE'},
                {'name': 'FREEZE_ACCOUNT', 'value' : 'FREEZE_ACCOUNT'},
            ],

            itemPartition: [
                {'name': 'APPLICATION_AREA', 'value' : 'APPLICATION_AREA'},
            ],

            item_transaction_type: [
                {'name': 'RECHARGE', 'value' : 'RECHARGE'},
                {'name': 'DEDUCTION', 'value' : 'DEDUCTION'},
            ],

            items: [
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

            tableCoinHeaders: [
                { text: "Serial Number", value: "id" },
                { text: "Partition", value: "partition" },
                { text: "Image", value: "image" },
                { text: "Base Currency", value: "coin.name" },
                { text: "Denominate Currency", value: "coin_pair.name" },
                { text: "Open for Trade", value: "open_for_trade_status" },
                { text: "Allows Currency Transaction", value: "currency_transaction_status" },
                { text: "Allows Contract Transactions", value: "contract_transaction_status" },
                { text: "Automatic Collection", value: "automatic_collection_status" },
                { text: "Mainstream Currency", value: "mainstream_currency_status" },
                { text: "Allow Withdrawal", value: "withdrawal_status" },
                { text: "Contract Delivery Cycle", value: "contract_delivery_cycle" },
                { text: "Queue Number", value: "queue_number" },
                { text: "Minimum Withdrawal Amount", value: "minimum_withdrawal_amount" },
                { text: "Minimum Buy", value: "withdrawal_fee" },
                { text: "Account Limit Required", value: "account_balance_limit" },
                { text: "Minimum Sell", value: "minimum_sell" },
                { text: "Volume", value: "volume" },
                { text: "Turnover", value: "turnover" },

                {
                    text: "Actions",
                    value: "actions",
                    sortable: false,
                    
                }
            ],

            tableCoinAssetsHeaders: [
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

            editedCoinIndex: -1,
            editedCoinPairInformation: {
                partition: null,
                coin_id: null, 
                coin_pair_id: null,
                open_for_trade_status: null,
                currency_transaction_status: null,
                contract_transaction_status: null,
                automatic_collection_status: null,
                mainstream_currency_status: null,
                withdrawal_status: null,
                contract_delivery_cycle: null,
                queue_number: null,
                minimum_withdrawal_amount: null,
                withdrawal_fee: null,
                account_balance_limit: null, 
                account_limit_required: null,
                minimum_sell: null,
                turnover: null,
                date: null,
                open: null,
                high:null,
                low: null,
                close: null,
                volume: null,
                price_range_from: null, 
                price_range_to: null,

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
        formCoinTitle() {
            return this.editedCoinIndex === -1
                ? "New Coin"
                : "Edit Coin";
        }
    },

    mounted() {
        this.fetchCoinpairs();
        this.fetchCoins();
    },

    created()
    {
        // this.randomData()
        // this.timer = setInterval(this.randomData, 1000)
    },

    methods: {
        updateChart(coin)
          {
            this.editedCoinIndex = this.tableCoins.indexOf(coin);
            this.editedCoinPairInformation = Object.assign({}, coin);
            this.formChartDialog = true;
            console.log(this.editedCoinPairInformation.id)
            this.ohlcv.pop()
            axios
                .get("/api/v1/chart", {
                    params: {
                        coin_pair_id: this.editedCoinPairInformation.id
                    }
                })
                .then(response => {
                    this.chartData = response.data.chart;
                    // this.date = this.chartData.date
                    
                    for(let i = 0; i < this.chartData.length; i++)
                    {
                        this.ohlcv.push(
                          [Number(this.chartData[i].date), 
                          Number(this.chartData[i].open), 
                          Number(this.chartData[i].high),
                          Number(this.chartData[i].low), 
                          Number(this.chartData[i].close), 
                          Number(this.chartData[i].volume)]
                      )
                    }

                    axios
                    .get("/api/v1/latest-candle", {
                        params: {
                            coin_pair_id: this.editedCoinPairInformation.id
                        }
                    })
                    .then(response => {
                        this.chartTick = response.data.chart;
                        this.date = this.chartTick.date
                        this.open = this.chartTick.open; 
                        this.high = this.chartTick.high;
                        this.low = this.chartTick.low; 
                        this.close = this.chartTick.close
                        this.volume = this.chartTick.volume;
                        this.price_range_from = this.chartTick.price_range_from;
                        this.price_range_to = this.chartTick.price_range_to;
                        
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
            
                    });
                      
                    // }
                    
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                  
                });

                this.formChartDialog = true
        },

        fetchChart(coin)
        {
                this.editedCoinIndex = this.tableCoins.indexOf(coinpair);
                this.editedCoinPairInformation = Object.assign({}, coinpair);
        },

          addToChart()
          { 
                    console.log(this.editedCoinPairInformation.id)
                      axios
                      .post("/api/v1/latest-candle/add", {
                            coin_pair_id: this.editedCoinPairInformation.id,
                            date: Number(this.date) + 3600000,
                            open: this.open,
                            high: this.high,
                            low: this.low,
                            close: this.close,
                            volume: this.volume,
                            price_range_from: this.price_range_from,
                            price_range_to: this.price_range_to,
                            })
                            .then(response => {
                                swal.fire({
                                position: "top-end",
                                toast: true,
                                type: "success",
                                icon: "success",
                                text: "Trend Created",
                                showConfirmButton: false,
                                timer: 1500
                    });
                            })
                            .catch(error => {
                                console.log(error);
                            })
                            .finally(() => {
                              
                            });                            
          },

        fetchCoinpairs() {
            this.tableLoading = true;
            this.componentOverlay = true;
            axios
                .get("/api/v1/coinpairs", {
                    params: {
                       pair_type: this.filter_coin_pair
                    }
                })
                .then(response => {
                    this.tableCoins = response.data.coinpairs;
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

        fetchAssets(coin)
        {
            this.editedCoinIndex = this.tableCoins.indexOf(coin);
            this.editedCoinPairInformation = Object.assign({}, coin);
            axios
                .get("/api/v1/wallets", {
                    params: {
                       client_id: this.editedCoinPairInformation.id
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

                this.formChartDialog = true
        },

        saveCoin() {
            this.componentOverlay = true;
            if (this.editedCoinIndex > -1) {
                this.updateCoin();
            } else {
                this.createCoin();
            }
        },

        createDeposit()
        {
            axios
                .post("/api/v1/deposits", {
                   client_id: this.editedCoinPairInformation.id,
                   coin_id: this.defaultCoinPairInformation.coin,
                   transaction_type: this.defaultCoinPairInformation.transaction_type,
                   included_in_performance: this.defaultCoinPairInformation.included_in_performance,
                   recharge_amount: this.defaultCoinPairInformation.amount,
                   account_type : this.editedCoinPairInformation.membership_level
                })
                .then(response => {
                    this.fetchCoins();
                    this.closeCoinForm();
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
                        this.formCoinErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        createCoin() {
            console.log(this.editedCoinPairInformation)
            axios
                .post("/api/v1/coinpairs", {
                    partition: this.editedCoinPairInformation.partition,
                    coin_id: this.editedCoinPairInformation.coin_id, 
                    coin_pair_id: this.editedCoinPairInformation.coin_pair_id,
                    open_for_trade_status: this.editedCoinPairInformation.open_for_trade_status,
                    currency_transaction_status: this.editedCoinPairInformation.currency_transaction_status,
                    contract_transaction_status: this.editedCoinPairInformation.contract_transaction_status,
                    automatic_collection_status: this.editedCoinPairInformation.automatic_collection_status,
                    mainstream_currency_status: this.editedCoinPairInformation.mainstream_currency_status,
                    withdrawal_status: this.editedCoinPairInformation.withdrawal_status,
                    contract_delivery_cycle: this.editedCoinPairInformation.contract_delivery_cycle,
                    queue_number: this.editedCoinPairInformation.queue_number,
                    minimum_withdrawal_amount: this.editedCoinPairInformation.minimum_withdrawal_amount,
                    withdrawal_fee: this.editedCoinPairInformation.withdrawal_fee,
                    account_balance_limit: this.editedCoinPairInformation.account_balance_limit, 
                    account_limit_required: this.editedCoinPairInformation.account_limit_required,
                    minimum_sell: this.editedCoinPairInformation.minimum_sell,
                    turnover: 1,
                })
                .then(response => {
                    this.fetchCoins();
                    this.closeCoinForm();
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
                        this.formCoinErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        editCoin(coin) {
            this.editedCoinIndex = this.tableCoins.indexOf(coin);
            this.editedCoinPairInformation = Object.assign({}, coin);
            this.formCoinDialog = true;
        },

        addRecharge(coin)
        {
            this.editedCoinIndex = this.tableCoins.indexOf(coin);
            this.editedCoinPairInformation = Object.assign({}, coin);
            this.formRechargeDialog = true;
        },

        updateCoin() {
            axios
                .put("/api/v1/coinpairs/" + this.editedCoinPairInformation.id, {
                    ..._.omit(this.editedCoinPairInformation, "user"),
                    ...this.editedCoinPairInformation.user,
                })
                .then(response => {
                    this.fetchCoinpairs();
                    this.closeCoinForm();
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
                        this.formCoinErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        deleteCoin(coin) {
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
                            .delete("/api/v1/coinpairs/" + coin.id)
                            .then(() => {
                                this.fetchCoins();
                                this.closeCoinForm();
                                swal.fire(
                                    "Deleted!",
                                    "Coin has been deleted.",
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

        closeCoinForm() {
            this.formCoinDialog = false;
            this.formRechargeDialog = false
            this.formChartDialog = false
            this.componentOverlay = false;
            this.deleteDialog = false;
            setTimeout(() => {
                this.formCoinErrors = {
                    name: null,
                    user: { username: null, password: null }
                };
                this.editedCoinPairInformation = Object.assign(
                    {},
                    this.defaultCoinInformation
                );
                this.editedCoinIndex = -1;
            }, 500);
        },

        getAccountInfo()
        {

            axios
                .get('https://api.trongrid.io/v1/accounts/TEJyCt244hWxVt126U4YD4uTX5haCWQUwy/')
                .then(response => {
                        console.log(response)
                    })
                .catch(error => {
                    this.componentOverlay = false;

                    if (error.response.status == 422) {
                        this.formCoinErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});

            
        },

        setIntervals()
        {
            setInterval(this.updateChart, 3000)
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
