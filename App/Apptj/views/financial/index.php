<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ locale.financial.page_title.index }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ locale.financial.index.graphs.all }}</h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:;" onclick="loadGeneralGraphs()">{{ locale.financial.index.graphs.update }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <canvas id="general_graphs"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ locale.financial.index.graphs.credit }}</h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:;" onclick="loadCreditGraphs()">{{ locale.financial.index.graphs.update }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <canvas id="credit_graphs"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ locale.financial.index.graphs.debit }}</h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:;" onclick="loadDebitGraphs()">{{ locale.financial.index.graphs.update }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <canvas id="debit_graphs"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ locale.financial.index.graphs.recurrence_credit }}</h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:;" onclick="loadRCreditGraphs()">{{ locale.financial.index.graphs.update }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <canvas id="recurrence_credit_graphs"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ locale.financial.index.graphs.recurrence_debit }}</h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:;" onclick="loadRDebitGraphs()">{{ locale.financial.index.graphs.update }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <canvas id="recurrence_debit_graphs"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var graphsGeneral,
        graphsCredit,
        graphsDebit,
        graphsRCredit,
        graphsRDebit;

    document.addEventListener('DOMContentLoaded',function () {
        loadGeneralGraphs();
        loadCreditGraphs();
        loadDebitGraphs();
        loadRCreditGraphs();
        loadRDebitGraphs();
    });

    function loadGeneralGraphs() {
        $.ajax({
            url: baseAPI + 'financial/graphs/general',
            success: function ($a) {

                if(graphsGeneral){
                    graphsGeneral.destroy();
                }

                graphsGeneral = new Chart(document.getElementById('general_graphs').getContext('2d'), {
                    type: 'bar',
                    data: $a.data,
                    options: {
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function(tooltipItems, data) {
                                    return numberParaReal(tooltipItems.yLabel);
                                },
                                title: function (tooltipItems, data) {
                                    return data.labels_complete[tooltipItems[0].index] + ' - ' + data.datasets[tooltipItems[0].datasetIndex].label2;
                                }
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value, index, values) {
                                        return numberParaReal(value);
                                    }
                                }
                            }]
                        }
                    }
                });


            }
        });
    }

    function loadCreditGraphs() {
        $.ajax({
            url: baseAPI + 'financial/graphs/credit',
            success: function ($a) {

                if(graphsCredit){
                    graphsCredit.destroy();
                }

                graphsCredit = new Chart(document.getElementById('credit_graphs').getContext('2d'), {
                    type: 'bar',
                    data: $a.data,
                    options: {
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function(tooltipItems, data) {
                                    return numberParaReal(tooltipItems.yLabel);
                                },
                                title: function (tooltipItems, data) {
                                    return data.labels_complete[tooltipItems[0].index] + ' - ' + data.datasets[tooltipItems[0].datasetIndex].label2;
                                }
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value, index, values) {
                                        return numberParaReal(value);
                                    }
                                }
                            }]
                        }
                    }
                });


            }
        });
    }

    function loadDebitGraphs() {
        $.ajax({
            url: baseAPI + 'financial/graphs/debit',
            success: function ($a) {

                if(graphsDebit){
                    graphsDebit.destroy();
                }

                graphsDebit = new Chart(document.getElementById('debit_graphs').getContext('2d'), {
                    type: 'bar',
                    data: $a.data,
                    options: {
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function(tooltipItems, data) {
                                    return numberParaReal(tooltipItems.yLabel);
                                },
                                title: function (tooltipItems, data) {
                                    return data.labels_complete[tooltipItems[0].index] + ' - ' + data.datasets[tooltipItems[0].datasetIndex].label2;
                                }
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value, index, values) {
                                        return numberParaReal(value);
                                    }
                                }
                            }]
                        }
                    }
                });


            }
        });
    }

    function loadRCreditGraphs() {
        $.ajax({
            url: baseAPI + 'financial/graphs/recurrence_credit',
            success: function ($a) {

                if(graphsRCredit){
                    graphsRCredit.destroy();
                }

                graphsRCredit = new Chart(document.getElementById('recurrence_credit_graphs').getContext('2d'), {
                    type: 'bar',
                    data: $a.data,
                    options: {
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function(tooltipItems, data) {
                                    return numberParaReal(tooltipItems.yLabel);
                                },
                                title: function (tooltipItems, data) {
                                    return data.labels_complete[tooltipItems[0].index] + ' - ' + data.datasets[tooltipItems[0].datasetIndex].label2;
                                }
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value, index, values) {
                                        return numberParaReal(value);
                                    }
                                }
                            }]
                        }
                    }
                });


            }
        });
    }

    function loadRDebitGraphs() {
        $.ajax({
            url: baseAPI + 'financial/graphs/recurrence_debit',
            success: function ($a) {

                if(graphsRDebit){
                    graphsRDebit.destroy();
                }

                graphsRDebit = new Chart(document.getElementById('recurrence_debit_graphs').getContext('2d'), {
                    type: 'bar',
                    data: $a.data,
                    options: {
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function(tooltipItems, data) {
                                    return numberParaReal(tooltipItems.yLabel);
                                },
                                title: function (tooltipItems, data) {
                                    return data.labels_complete[tooltipItems[0].index] + ' - ' + data.datasets[tooltipItems[0].datasetIndex].label2;
                                }
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value, index, values) {
                                        return numberParaReal(value);
                                    }
                                }
                            }]
                        }
                    }
                });


            }
        });
    }
</script>