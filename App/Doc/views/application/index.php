<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
    <h1>{{ locale.pages.applications.about.title }}</h1>
    <p>{{ locale.pages.applications.about.description }}</p>

    <br>

    <h4>{{ locale.pages.applications.about.type.title }}</h4>
    <p>{{ locale.pages.applications.about.type.description }}</p>

    <ul class="list-unstyled list-hidding">

        <li id="type_mvc">
            <a name="type_mvc"></a>
            <a href="application#type_mvc" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>

            <h5 class="config_name">{{ locale.pages.applications.about.type.mvc.title }}</h5>

            <div class="config_description hidden">
                <p>{{ locale.pages.applications.about.type.mvc.description }}</p>

                <h6>{{ locale.pages.applications.about.type.mvc.examples.title }}</h6>
                <ul>
                    <li>
                        {{ locale.pages.applications.about.type.mvc.examples.description }}
                        <p>{{ locale.pages.applications.about.type.mvc.examples.ex1 }}</p>
                        <p>{{ locale.pages.applications.about.type.mvc.examples.ex2 }}</p>
                    </li>
                </ul>
            </div>
        </li>

        <li id="type_restfull">
            <a name="type_restfull"></a>
            <a href="application#type_restfull" data-toggle="tooltip" data-placement="top" onclick="copyToClipboard('{{ locale.pages.applications.configuration.copytoclipboard }}',this.href)" title="{{ locale.pages.applications.configuration.copytoclipboard }}">
                <i class="fa fa-anchor" aria-hidden="true"></i>
            </a>

            <h5 class="config_name">{{ locale.pages.applications.about.type.restfull.title }}</h5>

            <div class="config_description hidden">
                <p>{{ locale.pages.applications.about.type.restfull.description }}</p>

                <h6>{{ locale.pages.applications.about.type.restfull.examples.title }}</h6>
                <ul>
                    <li>
                        {{ locale.pages.applications.about.type.restfull.examples.description }}
                        <p>{{ locale.pages.applications.about.type.restfull.examples.ex1 }}</p>
                        <p>{{ locale.pages.applications.about.type.restfull.examples.ex2 }}</p>
                    </li>
                </ul>
            </div>
        </li>

    </ul>

</main>
