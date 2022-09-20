
import Landing from "../components/views/Landing.vue";
import Signin from "../components/views/Signin.vue";
import Signup from "../components/views/Signup.vue";
import Pusher from '../components/views/Pusher.vue';

import AdminScaffold from '../components/views/Administrator/Scaffold.vue'
import AdminOfflineDepositAudit from '../components/views/Administrator/RechargeManagement/OfflineDepositAudit.vue'
import AdminOfflineDepositRecord from '../components/views/Administrator/RechargeManagement/OfflineDepositRecord.vue'
import AdminCurrencyTransferReview from '../components/views/Administrator/RechargeManagement/CurrencyTransferReview.vue'
import AdminOnlineDepositRecord from '../components/views/Administrator/RechargeManagement/OnlineDepositRecord.vue'
import AdminCustomerManagement from '../components/views/Administrator/CustomerManagement/CustomerManagement.vue'
import AdminPerformanceStatistics from '../components/views/Administrator/CustomerManagement/PerformanceStatistics.vue'

import AdminCustomerWithdrawalStatistics from '../components/views/Administrator/WithdrawalManagement/CustomerWithdrawalStatistics.vue'
import AdminWithdrawalAudit from '../components/views/Administrator/WithdrawalManagement/OnlineWithdrawalAudit.vue'
import AdminQuickSellingRecord from '../components/views/Administrator/WithdrawalManagement/QuickSellingRecord.vue'
import AdminUserWithdrawalRecord from '../components/views/Administrator/WithdrawalManagement/UserWithdrawalRecord.vue'

import AdminSpotOrder from '../components/views/Administrator/TradingManagement/SpotOrderRecord.vue'
import AdminContractTransfer from '../components/views/Administrator/TradingManagement/ContractTransferRecord.vue'
import AdminContractPosition from '../components/views/Administrator/TradingManagement/ContractPositionRecord.vue'

import AdminCoins from '../components/views/Administrator/Settings/Coins.vue'
import AdminCoinpairs from '../components/views/Administrator/Settings/CoinPairs.vue'
import AdminLiveData from '../components/views/Administrator/Settings/LiveDataChart.vue'

/** Clients */
import ClientLanding from '../components/views/ClientLanding.vue'
import ClientTrading from '../components/views/Trading/Trading.vue'
import ClientFuture from '../components/views/Trading/Futures.vue'
import ClientWallet from '../components/views/Wallet/ClientWallet.vue'
import ClientWalletFuture from '../components/views/Wallet/ClientWalletFuture.vue'
import ClientWalletDeposit from '../components/views/Wallet/ClientWalletDeposit.vue'
import ClientWalletWithdraw from '../components/views/Wallet/ClientWalletWithdraw.vue'





let adminRoutes = {
  path: "/admin", 
  component: AdminScaffold,
  redirect: "/administrator",
  name: "Components",
  children: [
    // { path: "purchase-histories", name: "Purchase Histories", components: { default: PurchaseHistory }},
    { path: "/administrator/offline-deposit-audit", name: "offline-deposit-audit", components: { default: AdminOfflineDepositAudit }},
    { path: "/administrator/offline-deposit-record", name: "offline-deposit-record", components: { default: AdminOfflineDepositRecord }},
    { path: "/administrator/currency-transfer-review", name: "currency-transfer-review", components: { default: AdminCurrencyTransferReview }},
    { path: "/administrator/online-deposit-record", name: "online-deposit-record", components: { default: AdminOnlineDepositRecord }},
    { path: "/administrator/customer-management", name: "customer-management", components: { default: AdminCustomerManagement }},
    { path: "/administrator/performance-statistics", name: "performance-task", components: { default: AdminPerformanceStatistics }},

    { path: "/administrator/online-withdrawal-audit", name: "online-withdrawal-audit", components: { default: AdminWithdrawalAudit }},
    { path: "/administrator/user-withdrawal-record", name: "user-withdrawal-record", components: { default: AdminUserWithdrawalRecord }},
    { path: "/administrator/quick-selling-record", name: "user-withdrawal-record", components: { default: AdminQuickSellingRecord }},
    { path: "/administrator/customer-withdrawal-statistics", name: "user-withdrawal-record", components: { default: AdminCustomerWithdrawalStatistics }},

    { path: "/administrator/spot-trading", name: "online-withdrawal-audit", components: { default: AdminSpotOrder }},
    { path: "/administrator/contract-transfers", name: "user-withdrawal-record", components: { default: AdminContractTransfer }},
    { path: "/administrator/contract-positions", name: "user-withdrawal-record", components: { default: AdminContractPosition }},

    {path: "/administrator/coins", name: "coins", components: { default: AdminCoins}},
    {path: "/administrator/coin-pairs", name: "coin-pairs", components: { default: AdminCoinpairs}},

    {path: "/administrator/live-data", name: "coin-pairs", components: { default: AdminLiveData}},
  ]
};

let clientRoutes = {
    path: "/",
    component: ClientLanding,
    name: "ClientLanding",

    path: "/wallet",
    component: ClientWallet,
    name: "ClientWallet"
}

const routes = [
  {
    path: "/administrator/signin",
    name: "admin-signin",
    component: Signin,
  },
  {
    path: "/login",
    name: "Signin",
    component: Signin,
  },
  // {
  //   path: "/register",
  //   name: "Signup",
  //   component: Signup,
  // },
//   subsriberRoutes,

  // Sample Route For Pusher
  {
      path: "/pusher",
      name: "Pusher",
      component: Pusher
  }, 

  {path: "/spot/orders", name: "coin-pairs", components: { default: ClientTrading}},
  {path: "/future/orders", name: "coin-pairs", components: { default: ClientFuture}},
  {path: "/wallet/spot", name: "coin-pairs", components: { default: ClientWallet}},
  {path: "/wallet/future", name: "coin-pairs", components: { default: ClientWalletFuture}},
  {path: "/wallet/deposit", name: "coin-pairs", components: { default: ClientWalletDeposit}},
  {path: "/wallet/withdraw", name: "coin-pairs", components: { default: ClientWalletWithdraw}},

  {
    path: "/",
    component: ClientLanding,
    name: "ClientLanding",
},
  adminRoutes, 
];

export default routes;
