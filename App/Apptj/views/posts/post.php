<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>{{ locale.posts.new_post.title }}</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ locale.posts.new_post.content }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Resetar Conteudo</a></li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <textarea id="post_content" name="post_content"></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ locale.posts.new_post.options.title }}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12" >
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <button class="btn btn-success form-control" data-toggle="tooltip" data-placement="top" title="{{ locale.posts.new_post.options.galery_popup }}">
                                {{ locale.posts.new_post.options.galery }}
                                <i class="fa fa-image"></i>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <button class="btn btn-success form-control" onclick="postsForm.novo()" data-toggle="tooltip" data-placement="top" title="{{ locale.posts.new_post.options.save_popup }}">
                                {{ locale.posts.new_post.options.save }}
                                <i class="fa fa-floppy-o"></i>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <button class="btn btn-success form-control" data-toggle="tooltip" data-placement="top" title="{{ locale.posts.new_post.options.favorite_popup }}">
                                {{ locale.posts.new_post.options.favorite }}
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <button class="btn btn-danger form-control" data-toggle="tooltip" data-placement="top" title="{{ locale.posts.new_post.options.delete_popup }}">
                                {{ locale.posts.new_post.options.delete }}
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="post_author">{{ locale.posts.new_post.options.author }}</label>
                            <select id="post_author" class="form-control">
                                <option>Jorge Carlos</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="post_date">{{ locale.posts.new_post.options.date }}</label>
                            <input id="post_date" class="form-control" type="datetime-local">
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="post_state">{{ locale.posts.new_post.options.status }}</label>
                            <select id="post_state" class="form-control">
                                <option>Novo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="x_panel post_component_line_1">
                <div class="x_title">
                    <h2>{{ locale.posts.new_post.categories }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <label for="categories">{{ locale.posts.new_post.categories_description }}</label>

                    <select id="post_categorie" class="form-control">
                        <option>The Sims 4 Lançamento</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="x_panel post_component_line_1">
                <div class="x_title">
                    <h2>{{ locale.posts.new_post.tags }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <label for="post_tags">{{ locale.posts.new_post.tags_description }}</label>
                    <input id="post_tags" class="form-control">

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="x_panel post_component_line_1">
                <div class="x_title">
                    <h2>{{ locale.posts.new_post.type }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <label for="type">{{ locale.posts.new_post.type_description }}</label>

                    <select id="post_type" class="form-control">
                        <option>Portifolio</option>
                    </select>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded',function () {
        postsForm.loadPostFormData();

        tinymce.init({
            selector: '#textarea',
            height: 500,
            theme: 'modern',
            menu: {
                file: {title: 'File', items: 'print'},
                edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
                insert: {title: 'Insert', items: 'link media | template hr'},
                format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
                table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
                tools: {title: 'Tools', items: 'spellchecker code'}
            },
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ],
            language: 'pt_BR'
        });
    })
</script>