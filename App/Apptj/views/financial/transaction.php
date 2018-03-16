<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ locale.financial.page_title.transaction }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ locale.financial.page_title.transaction }} <small>{{ locale.financial.transaction.description }} </small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="transaction-form" class="form-horizontal form-label-left">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="transaction_name">{{ locale.financial.transaction.name }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="transaction_name" required class="form-control col-md-7 col-xs-12" name="name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="transaction_currency" class="control-label col-md-3 col-sm-3 col-xs-12">{{ locale.financial.transaction.currency.title }}</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="transaction_currency" class="form-control col-md-7 col-xs-12" name="currency" onchange="changeCurrency(this.value)">
                                        <option value="BRL" selected>{{ locale.financial.transaction.currency.items.BRL }}</option>
                                        <option value="USD">{{ locale.financial.transaction.currency.items.USD }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="transaction_value" class="control-label col-md-3 col-sm-3 col-xs-12">{{ locale.financial.transaction.value }}</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="transaction_value_BRL" class="form-control moneyMask col-md-7 col-xs-12" data-prefix="R$ " data-thousands="." data-decimal="," name="value">
                                    <input id="transaction_value_USD" class="form-control moneyMask col-md-7 col-xs-12" data-prefix="$ " data-thousands="" data-decimal="." style="display: none">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="transaction_recurrence" class="control-label col-md-3 col-sm-3 col-xs-12">{{ locale.financial.transaction.recurrence }}</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" id="transaction_recurrence" class="icheckbox" name="recurrence">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ locale.financial.transaction.type.title }}</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-success active" data-toggle-class="btn-success" data-toggle-passive-class="btn-default">
                                            <input id="transaction_type" type="radio" required name="type" checked value="1"> &nbsp; {{ locale.financial.transaction.type.credit }} &nbsp;
                                        </label>
                                        <label class="btn btn-danger" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                                            <input id="transaction_type" type="radio" required name="type" value="0"> {{ locale.financial.transaction.type.debit }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="transaction_date" class="control-label col-md-3 col-sm-3 col-xs-12">{{ locale.financial.transaction.date }}</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="transaction_date" class="form-control col-md-7 col-xs-12" type="datetime-local" name="date">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="transaction_comment" class="control-label col-md-3 col-sm-3 col-xs-12">{{ locale.financial.transaction.comment }}</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="transaction_comment" class="date-picker form-control col-md-7 col-xs-12" name="comment"></textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="reset">Resetar</button>
                                    <button class="btn btn-success">Enviar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded',function () {
        $('#transaction_date4').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            locale: 'pt-br',
            sideBySide: true
        });

        $('#transaction_value_BRL').maskMoney({
            affixesStay: false
        });

        $('#transaction-form').on('submit',function () {
            
            $.ajax({
                type:'post',
                url: baseAPI + 'financial/new',
                data: $('#transaction-form').serializeArray(),
                dataType: 'json',
                success:function (a) {
                    if(a.status === '1'){
                        pnotify('success',{title:'Successo!',text:'Transação salva com sucesso!'});
                    } else {
                        pnotify('error',{title:'Erro:',text:a.error});
                    }
                }
            });

            return false;
        });
    });
    
    function changeCurrency($currency) {
        var $maskMoney = $('.moneyMask'),
            $field = $('#transaction_value_' + $currency);

        $maskMoney.maskMoney('destroy');
        $maskMoney.hide();
        $maskMoney.val('');
        $maskMoney.removeAttr('name');

        $field.maskMoney({
            affixesStay: false
        });
        $field.attr('name','value');
        $field.fadeIn();
    }
</script>