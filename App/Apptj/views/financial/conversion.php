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
                        <h2>{{ locale.financial.page_title.conversion }} <small>{{ locale.financial.conversion.description }} </small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="conversion_form" class="form-horizontal form-label-left">

                            <div class="form-group">
                                <label for="conversion_value" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ locale.financial.conversion.value }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="conversion_value" required name="conversion_value" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="conversion_currency" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ locale.financial.transaction.currency }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="conversion_currency" class="form-control col-md-7 col-xs-12" name="conversion_currency">
                                        <option value="BRL" data-before-prefix="$ ">Dólar Americano - USD</option>
                                        <option value="USD" data-before-prefix="$ ">Dólar Americano - USD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-success">Converter</button>
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

        $('#conversion_form').on('submit', function (a) {

            var $moeda = $('#conversion_currency').val(),
                $valor = $('#conversion_value').val();

            $.ajax({
                url: window.location.origin +'/financial/getCotacao/'+ $moeda,
                dataType: 'json',
                success:function (a) {
                    console.log(a);
                }
            });

            return false;
        });
    });
</script>