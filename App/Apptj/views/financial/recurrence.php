<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ locale.financial.page_title.history }}</h3>
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
                        <table id="recurrence_table" class="table table-responsive table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Moeda</th>
                                <th>Usuario</th>
                                <th>Tipo</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded',function () {

        $('#recurrence_table').DataTable({
            serverSide: true,
            ajax:{
                url: baseAPI + 'financialrecurrence/table',
                type: 'post'
            },
            columns: [
                { "name": "id" },
                { "name": "name" },
                { "name": "value" },
                { "name": "currency" },
                { "name": "user" },
                { "name": "type" },
                { "name": "date" }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json'
            },
            dom: 'Blfrtip',
            buttons: [
                'excel', 'pdfHtml5','print'
            ],
            select: true,
            keys: true,
            fixedHeader: true
        });
    });

</script>