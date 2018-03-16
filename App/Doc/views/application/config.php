<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
    <h1>{{ locale.pages.applications.configuration.title }}</h1>

    <p>{{ locale.pages.applications.configuration.text1 }}</p>

    <br>

    <h2>{{ locale.pages.applications.configuration.config_global.title }}</h2>
    <p>{{ locale.pages.applications.configuration.config_global.description }}</p>

    <ul class="list-unstyled list-hidding config_list">

        <li name="global_apps">
            <a href="application/configuration#global_apps" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$C['apps']</h5>
            <div class="config_description hidden">
                <p>{{ locale.pages.applications.configuration.config_global.items.apps.description }}</p>
                <p>{{ locale.pages.applications.configuration.config_global.items.apps.text1 }}</p>
                <p>{{ locale.pages.applications.configuration.config_global.items.apps.text2 }}</p>
                <p><strong>{{ locale.pages.applications.configuration.types_allowed }}</strong>{{ locale.pages.applications.configuration.config_global.items.apps.type }}</p>

                <br>

                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.apps.text1_alert }}
                </div>
                <div class="alert alert-danger" role="alert">
                    {{ locale.pages.applications.configuration.config_global.can_not_be_changed }}
                </div>
            </div>
        </li>

        <li name="global_multiapps">
            <a href="application/configuration#global_multiapps" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$C['multiapps']</h5>
            <div class="config_description hidden">
                <p>{{ locale.pages.applications.configuration.config_global.items.multiapps.description }}</p>
                <p><strong>{{ locale.pages.applications.configuration.default }}</strong>{{ locale.pages.applications.configuration.config_global.items.multiapps.default }}</p>
                <p><strong>{{ locale.pages.applications.configuration.types_allowed }}</strong>{{ locale.pages.applications.configuration.config_global.items.multiapps.type }}</p>

                <br>

                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.multiapps.text2_alert }}
                </div>
                <div class="alert alert-danger" role="alert">
                    {{ locale.pages.applications.configuration.config_global.can_not_be_changed }}
                </div>

            </div>
        </li>

        <li name="global_default_app">
            <a href="application/configuration#global_default_app" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$C['default_app']</h5>
            <div class="config_description hidden">
                <p>{{ locale.pages.applications.configuration.config_global.items.default_app.description }}</p>
                <p>{{ locale.pages.applications.configuration.config_global.items.default_app.text1 }}</p>
                <p><strong>{{ locale.pages.applications.configuration.types_allowed }}</strong>{{ locale.pages.applications.configuration.config_global.items.default_app.type }}</p>

                <br>

                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.default_app.text1_alert }}
                </div>
                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.default_app.text2_alert }}
                </div>
                <div class="alert alert-danger" role="alert">
                    {{ locale.pages.applications.configuration.config_global.can_not_be_changed }}
                </div>

            </div>
        </li>

        <li name="global_default_language">
            <a href="application/configuration#global_default_language" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$C['default_language']</h5>
            <div class="config_description hidden">
                <p>{{ locale.pages.applications.configuration.config_global.items.default_language.description }}</p>
                <p>{{ locale.pages.applications.configuration.config_global.items.default_language.text1 }}</p>
                <p><strong>{{ locale.pages.applications.configuration.default }}</strong>{{ locale.pages.applications.configuration.config_global.items.default_language.default }}</p>
                <p><strong>{{ locale.pages.applications.configuration.types_allowed }}</strong>{{ locale.pages.applications.configuration.config_global.items.default_language.type }}</p>

                <br>

                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.default_language.text1_alert }}
                </div>
                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.default_language.text2_alert }}
                </div>
                <div class="alert alert-success" role="alert">
                    {{ locale.pages.applications.configuration.config_global.can_be_changed }}
                </div>

            </div>
        </li>

        <li name="global_language_file_type">
            <a href="application/configuration#global_language_file_type" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$C['language_file_type']</h5>
            <div class="config_description hidden">
                <p>{{ locale.pages.applications.configuration.config_global.items.language_file_type.description }}</p>
                <p>{{ locale.pages.applications.configuration.config_global.items.language_file_type.text1 }}</p>
                <p>{{ locale.pages.applications.configuration.default }}{{ locale.pages.applications.configuration.config_global.items.language_file_type.default }}</p>
                <p>{{ locale.pages.applications.configuration.types_allowed }}{{ locale.pages.applications.configuration.config_global.items.language_file_type.type }}</p>

                <br>

                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.language_file_type.text1_alert }}
                </div>
                <div class="alert alert-success" role="alert">
                    {{ locale.pages.applications.configuration.config_global.can_be_changed }}
                </div>
            </div>
        </li>

        <li name="global_language_return_type">
            <a href="application/configuration#global_language_return_type" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$C['language_return_type']</h5>
            <div class="config_description hidden">
                <p>{{ locale.pages.applications.configuration.config_global.items.language_return_type.description }}</p>
                <p>{{ locale.pages.applications.configuration.config_global.items.language_return_type.text1 }}</p>
                <p><strong>{{ locale.pages.applications.configuration.default }}</strong>{{ locale.pages.applications.configuration.config_global.items.language_return_type.default }}</p>
                <p><strong>{{ locale.pages.applications.configuration.types_allowed }}</strong>{{ locale.pages.applications.configuration.config_global.items.language_return_type.type }}</p>

                <br>

                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_global.items.language_return_type.text1_alert }}
                </div>
                <div class="alert alert-success" role="alert">
                    {{ locale.pages.applications.configuration.config_global.can_be_changed }}
                </div>
            </div>

        </li>

    </ul>

    <br>

    <h2>{{ locale.pages.applications.configuration.config_app.title }}</h2>
    <p>{{ locale.pages.applications.configuration.config_app.description }}</p>

    <ul class="list-unstyled config_list list-hidding">

        <li name="app_app_name">
            <a href="application/configuration#app_app_name" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$A['app_name']</h5>
            <div class="config_description hidden">
                <p>{{ locale.pages.applications.configuration.config_app.items.app_name.description }}</p>
                <p>{{ locale.pages.applications.configuration.config_app.items.app_name.text1 }}</p>
                <p><strong>{{ locale.pages.applications.configuration.types_allowed }}</strong>{{ locale.pages.applications.configuration.config_app.items.app_name.type }}</p>

                <br>

                <div class="alert alert-info" role="alert">
                    {{ locale.pages.applications.configuration.config_app.items.app_name.text1_alert }}
                </div>
            </div>
        </li>

        <li name="app_app_folder">
            <a href="application/configuration#app_app_folder" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>
            <h5 class="config_name">$A['app_folder']</h5>
            <div class="config_description hidden   ">
                <p>{{ locale.pages.applications.configuration.config_app.items.app_folder.description }}</p>
                <p>{{ locale.pages.applications.configuration.config_app.items.app_folder.text1 }}</p>
                <p>{{ locale.pages.applications.configuration.config_app.items.app_folder.text2 }}</p>
                <p><strong>{{ locale.pages.applications.configuration.types_allowed }}</strong>{{ locale.pages.applications.configuration.config_app.items.app_folder.type }}</p>

                <br>

                <div class="alert alert-warning" role="alert">
                    {{ locale.pages.applications.configuration.config_app.items.app_folder.text1_alert }}
                </div>

            </div>
        </li>

    </ul>

</main>