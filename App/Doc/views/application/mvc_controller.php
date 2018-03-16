<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">

    <h1>{{ locale.pages.applications.mvc_controller.title }}</h1>

    <p>{{ locale.pages.applications.mvc_controller.text1 }}</p>

    <br>

    <p>{{ locale.pages.applications.mvc_controller.text2 }}</p>

    <div id="characteristics">
        <h4>{{ locale.pages.applications.mvc_controller.characteristics.title }}</h4>
        <p>{{ locale.pages.applications.mvc_controller.characteristics.description }}</p>

        <ul class="list-unstyled list-hidding">

            <li id="characteristics_cache">
                <a href="application/mvc_controller#characteristics_cache" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                    <i class="fa fa-anchor" aria-hidden="true"></i>
                </a>

                <h5 class="config_name">Cache</h5>

                <div class="config_description hidden">

                    <p>{{ locale.pages.applications.mvc_controller.characteristics.cache.text1 }}</p>

                    <h5>{{ locale.pages.applications.mvc_controller.characteristics.cache.desactive.title }}</h5>
                    <p>{{ locale.pages.applications.mvc_controller.characteristics.cache.desactive.text1 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.characteristics.cache.desactive.text2 }}</p>

                    <h5>{{ locale.pages.applications.mvc_controller.characteristics.cache.cache_key.title }}</h5>
                    <p>{{ locale.pages.applications.mvc_controller.characteristics.cache.cache_key.text1 }}</p>

                </div>

            </li>

        </ul>

    </div>

    <div id="properties">
        <h4>{{ locale.pages.applications.mvc_controller.properties.title }}</h4>
        <p>{{ locale.pages.applications.mvc_controller.properties.description }}</p>

        <ul class="list-unstyled list-hidding">

            <li id="properties_disable_cache">
                <a href="application/mvc_controller#properties_disable_cache" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                    <i class="fa fa-anchor" aria-hidden="true"></i>
                </a>

                <h5 class="config_name">$disable_cache</h5>

                <div class="config_description hidden">

                    <p>{{ locale.pages.applications.mvc_controller.properties.disable_cache.text1 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.properties.disable_cache.text2 }}</p>

                    <div class="alert alert-info">
                        {{ locale.pages.applications.mvc_controller.properties.disable_cache.alert1 }}
                    </div>

                </div>

            </li>

            <li id="properties_view_by_folder">
                <a href="application/mvc_controller#properties_view_by_folder" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                    <i class="fa fa-anchor" aria-hidden="true"></i>
                </a>

                <h5 class="config_name">$view_by_folder</h5>

                <div class="config_description hidden">

                    <p>{{ locale.pages.applications.mvc_controller.properties.view_by_folder.text1 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.properties.view_by_folder.text2 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.properties.view_by_folder.text3 }}</p>

                    <div class="alert alert-info">
                        {{ locale.pages.applications.mvc_controller.properties.view_by_folder.alert1 }}
                    </div>

                </div>

            </li>

            <li id="properties_custom_view_folder">
                <a href="application/mvc_controller#properties_custom_view_folder" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                    <i class="fa fa-anchor" aria-hidden="true"></i>
                </a>

                <h5 class="config_name">$custom_view_folder</h5>

                <div class="config_description hidden">

                    <p>{{ locale.pages.applications.mvc_controller.properties.custom_view_folder.text1 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.properties.custom_view_folder.text2 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.properties.custom_view_folder.text3 }}</p>

                    <div class="alert alert-info">
                        {{ locale.pages.applications.mvc_controller.properties.custom_view_folder.alert1 }}
                    </div>

                </div>

            </li>

            <li id="properties_disable_all_template">
                <a href="application/mvc_controller#properties_disable_all_template" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                    <i class="fa fa-anchor" aria-hidden="true"></i>
                </a>

                <h5 class="config_name">$disable_all_template</h5>

                <div class="config_description hidden">

                    <p>{{ locale.pages.applications.mvc_controller.properties.disable_all_template.text1 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.properties.disable_all_template.text2 }}</p>

                    <div class="alert alert-info">
                        {{ locale.pages.applications.mvc_controller.properties.disable_all_template.alert1 }}
                    </div>

                </div>

            </li>
        </ul>
    </div>

    <br>

    <div id="functions">

        <h4>{{ locale.pages.applications.mvc_controller.functions.title }}</h4>

        <p>{{ locale.pages.applications.mvc_controller.functions.text1 }}</p>

        <ul class="list-unstyled list-hidding">

            <li id="mvc_controller_view">
                <a href="application/mvc_controller#mvc_controller_view" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                    <i class="fa fa-anchor" aria-hidden="true"></i>
                </a>

                <h5 class="config_name">view(<span class="value_type">string</span> <span class="value_variable">$file</span>, <span class="value_type">array</span> <span class="value_variable">$data</span>, <span class="value_type">bool</span> <span class="value_variable">$disableTemplate</span> )</h5>

                <div class="config_description hidden">

                    <p>{{ locale.pages.applications.mvc_controller.functions.functionView.description }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.functions.functionView.args }}</p>

                </div>
            </li>

            <li id="mvc_controller_load">
                <a href="application/mvc_controller#mvc_controller_load" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                    <i class="fa fa-anchor" aria-hidden="true"></i>
                </a>

                <h5 class="config_name">load(<span class="value_type">string</span> <span class="value_variable">$type</span>, <span class="value_type">string/array</span> <span class="value_variable">$file</span>, <span class="value_type">string</span> <span class="value_variable">$app</span> )</h5>

                <div class="config_description hidden">

                    <p>{{ locale.pages.applications.mvc_controller.functions.functionLoad.description }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.functions.functionLoad.args.arg1 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.functions.functionLoad.args.arg2 }}</p>
                    <p>{{ locale.pages.applications.mvc_controller.functions.functionLoad.args.arg3 }}</p>

                    <div class="alert alert-info">
                        {{ locale.pages.applications.mvc_controller.functions.functionLoad.text1_alert }}
                    </div>

                </div>
            </li>

        </ul>
    </div>

</main>
