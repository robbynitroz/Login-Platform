<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <b-card class="bg-primary" :no-body="true">
                    <div class="card-body pb-0">
                        <b-dropdown class="float-right" variant="transparent p-0" right>
                            <template slot="button-content">
                                <i class="icon-settings"></i>
                            </template>
                            <b-dropdown-item>Action</b-dropdown-item>
                            <b-dropdown-item>Another action</b-dropdown-item>
                            <b-dropdown-item>Something else here...</b-dropdown-item>
                            <b-dropdown-item disabled>Disabled action</b-dropdown-item>
                        </b-dropdown>
                        <h4 class="mb-0">2</h4>
                        <p>Users online</p>
                    </div>
                    <card-line1-chart-example class="chart-wrapper px-3" style="height:70px;" height="70"/>
                </b-card>
            </div><!--/.col-->
            <div class="col-sm-6 col-lg-3">
                <b-card class="bg-info" :no-body="true">
                    <div class="card-body pb-0">
                        <b-dropdown class="float-right" variant="transparent p-0" right no-caret>
                            <template slot="button-content">
                                <i class="icon-location-pin"></i>
                            </template>
                            <b-dropdown-item>Action</b-dropdown-item>
                            <b-dropdown-item>Another action</b-dropdown-item>
                            <b-dropdown-item>Something else here...</b-dropdown-item>
                            <b-dropdown-item disabled>Disabled action</b-dropdown-item>
                        </b-dropdown>
                        <h4 class="mb-0">2</h4>
                        <p>Routers online</p>
                    </div>
                    <card-line2-chart-example class="chart-wrapper px-3" style="height:70px;" height="70"/>
                </b-card>
            </div><!--/.col-->
            <div class="col-sm-6 col-lg-3">
                <b-card class="bg-warning" :no-body="true">
                    <div class="card-body pb-0">
                        <b-dropdown class="float-right" variant="transparent p-0" right>
                            <template slot="button-content">
                                <i class="icon-settings"></i>
                            </template>
                            <b-dropdown-item>Action</b-dropdown-item>
                            <b-dropdown-item>Another action</b-dropdown-item>
                            <b-dropdown-item>Something else here...</b-dropdown-item>
                            <b-dropdown-item disabled>Disabled action</b-dropdown-item>
                        </b-dropdown>
                        <h4 class="mb-0">389 MB</h4>
                        <p>Server memory usage</p>
                    </div>
                    <card-line3-chart-example class="chart-wrapper" style="height:70px;" height="70"/>
                </b-card>
            </div><!--/.col-->
            <div class="col-sm-6 col-lg-3">
                <b-card class="bg-danger" :no-body="true">
                    <div class="card-body pb-0">
                        <b-dropdown class="float-right" variant="transparent p-0" right>
                            <template slot="button-content">
                                <i class="icon-settings"></i>
                            </template>
                            <b-dropdown-item>Action</b-dropdown-item>
                            <b-dropdown-item>Another action</b-dropdown-item>
                            <b-dropdown-item>Something else here...</b-dropdown-item>
                            <b-dropdown-item disabled>Disabled action</b-dropdown-item>
                        </b-dropdown>
                        <h4 class="mb-0">10%</h4>
                        <p>Server CPU usage</p>
                    </div>
                    <card-bar-chart-example class="chart-wrapper px-3" style="height:70px;" height="70"/>
                </b-card>
            </div><!--/.col-->
        </div><!--/.row-->

        <b-card>
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">Traffic</h4>
                    <div class="small text-muted">November 2016</div>
                </div><!--/.col-->
                <div class="col-sm-7 d-none d-md-block">
                    <b-button type="button" variant="primary" class="float-right"><i class="icon-cloud-download"></i></b-button>
                    <b-button-toolbar class="float-right" aria-label="Toolbar with button groups">
                        <b-button-group class="mr-3" aria-label="First group">
                            <b-button variant="outline-secondary">Day</b-button>
                            <b-button variant="outline-secondary" :pressed="true">Month</b-button>
                            <b-button variant="outline-secondary">Year</b-button>
                        </b-button-group>
                    </b-button-toolbar>
                </div><!--/.col-->
            </div><!--/.row-->
            <main-chart-example class="chart-wrapper" style="height:300px;margin-top:40px;" height="300"></main-chart-example>
            <div slot="footer">
                <ul>
                    <li>
                        <div class="text-muted">Visits</div>
                        <strong>29.703 Users (40%)</strong>
                        <b-progress class="progress-xs mt-2" :precision="1" variant="success" :value="40"></b-progress>
                    </li>
                    <li class="d-none d-md-table-cell">
                        <div class="text-muted">Unique</div>
                        <strong>24.093 Users (20%)</strong>
                        <b-progress class="progress-xs mt-2" :precision="1" variant="info" :value="20"></b-progress>
                    </li>
                    <li>
                        <div class="text-muted">Pageviews</div>
                        <strong>78.706 Views (60%)</strong>
                        <b-progress class="progress-xs mt-2" :precision="1" variant="warning" :value="60"></b-progress>
                    </li>
                    <li class="d-none d-md-table-cell">
                        <div class="text-muted">New Users</div>
                        <strong>22.123 Users (80%)</strong>
                        <b-progress class="progress-xs mt-2" :precision="1" variant="danger" :value="80"></b-progress>
                    </li>
                    <li class="d-none d-md-table-cell">
                        <div class="text-muted">Bounce Rate</div>
                        <strong>40.15%</strong>
                        <b-progress class="progress-xs mt-2" :precision="1" :value="40"></b-progress>
                    </li>
                </ul>
            </div>
        </b-card>
        <div class="row">
            <div class="col-sm-6 col-lg-3">

            </div><!--/.col-->

        </div><!--/.row-->

    </div>
</template>

<script>
    import CardLine1ChartExample from './dashboard/CardLine1ChartExample'
    import CardLine2ChartExample from './dashboard/CardLine2ChartExample'
    import CardLine3ChartExample from './dashboard/CardLine3ChartExample'
    import CardBarChartExample from './dashboard/CardBarChartExample'
    import MainChartExample from './dashboard/MainChartExample'
    import SocialBoxChartExample from './dashboard/SocialBoxChartExample'
    import CalloutChartExample from './dashboard/CalloutChartExample'
    import  Callout  from './additional-components/Callout.vue'


    export default {
        name: 'dashboard',
        components: {
            Callout,
            CardLine1ChartExample,
            CardLine2ChartExample,
            CardLine3ChartExample,
            CardBarChartExample,
            MainChartExample,
            SocialBoxChartExample,
            CalloutChartExample
        },
        data: function () {
            return {
                tableItems: [
                    {
                        avatar: { url: '/storage/images/avatars/1.jpg', status: 'success' },
                        user: { name: 'Yiorgos Avraamu', new: true, registered: 'Jan 1, 2015' },
                        country: { name: 'USA', flag: '/storage/images/flags/USA.png' },
                        usage: { value: 50, period: 'Jun 11, 2015 - Jul 10, 2015' },
                        payment: { name: 'Mastercard', icon: 'fa fa-cc-mastercard' },
                        activity: '10 sec ago'
                    },
                    {
                        avatar: { url: '/storage/images/avatars/2.jpg', status: 'danger' },
                        user: { name: 'Avram Tarasios', new: false, registered: 'Jan 1, 2015' },
                        country: { name: 'Brazil', flag: '/storage/images/flags/Brazil.png' },
                        usage: { value: 22, period: 'Jun 11, 2015 - Jul 10, 2015' },
                        payment: { name: 'Visa', icon: 'fa fa-cc-visa' },
                        activity: '5 minutes ago'
                    },
                    {
                        avatar: { url: '/storage/images/avatars/3.jpg', status: 'warning' },
                        user: { name: 'Quintin Ed', new: true, registered: 'Jan 1, 2015' },
                        country: { name: 'India', flag: '/storage/images/flags/India.png' },
                        usage: { value: 74, period: 'Jun 11, 2015 - Jul 10, 2015' },
                        payment: { name: 'Stripe', icon: 'fa fa-cc-stripe' },
                        activity: '1 hour ago'
                    },
                    {
                        avatar: { url: '/storage/images/avatars/4.jpg', status: '' },
                        user: { name: 'Enéas Kwadwo', new: true, registered: 'Jan 1, 2015' },
                        country: { name: 'France', flag: '/storage/images/flags/France.png' },
                        usage: { value: 98, period: 'Jun 11, 2015 - Jul 10, 2015' },
                        payment: { name: 'PayPal', icon: 'fa fa-paypal' },
                        activity: 'Last month'
                    },
                    {
                        avatar: { url: '/storage/images/avatars/5.jpg', status: 'success' },
                        user: { name: 'Agapetus Tadeáš', new: true, registered: 'Jan 1, 2015' },
                        country: { name: 'Spain', flag: '/storage/images/flags/Spain.png' },
                        usage: { value: 22, period: 'Jun 11, 2015 - Jul 10, 2015' },
                        payment: { name: 'Google Wallet', icon: 'fa fa-google-wallet' },
                        activity: 'Last week'
                    },
                    {
                        avatar: { url: '/storage/images/avatars/6.jpg', status: 'danger' },
                        user: { name: 'Friderik Dávid', new: true, registered: 'Jan 1, 2015' },
                        country: { name: 'Poland', flag: '/storage/images/flags/Poland.png' },
                        usage: { value: 43, period: 'Jun 11, 2015 - Jul 10, 2015' },
                        payment: { name: 'Amex', icon: 'fa fa-cc-amex' },
                        activity: 'Last week'
                    }
                ],
                tableFields: {
                    avatar: {
                        label: '<i class="icon-people"></i>',
                        class: 'text-center'
                    },
                    user: {
                        label: 'User'
                    },
                    country: {
                        label: 'Country',
                        class: 'text-center'
                    },
                    usage: {
                        label: 'Usage'
                    },
                    payment: {
                        label: 'Payment method',
                        class: 'text-center'
                    },
                    activity: {
                        label: 'Activity'
                    }
                }
            }
        },
        methods: {
            variant (value) {
                let $variant
                if (value <= 25) {
                    $variant = 'info'
                } else if (value > 25 && value <= 50) {
                    $variant = 'success'
                } else if (value > 50 && value <= 75) {
                    $variant = 'warning'
                } else if (value > 75 && value <= 100) {
                    $variant = 'danger'
                }
                return $variant
            }
        }
    }
</script>