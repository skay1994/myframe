<script>
    var is_redirect = <?= $redirect ? 'true': 'false'?>,
        redirect_url = '<?= $redirect_url ?? ''?>';
</script>
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
    <a class="hiddenanchor" id="recoverypass"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form id="login_form" onsubmit="login.login();return false;">
                    <h1>Login</h1>
                    <div id="alert"></div>
                    <div>
                        <input class="form-control" placeholder="Email" name="email" required="" />
                    </div>
                    <div>
                        <input class="form-control" placeholder="Senha" name="password" type="password"required="" />
                    </div>
                    <div>
                        <button class="btn btn-default submit" type="submit">Login</button>
                        <a class="reset_pass" href="#recoverypass">Esqueceu a senha?</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">Novo por aqui?
                            <a href="#signup" class="to_register"> Crie uma conta!</a>
                        </p>


                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> TJ Desenvolvimento!</h1>
                            <p>©2017 All Rights Reserved. TJ Desenvolvimento!</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>

        <div class="animate form recovery_form">
            <section class="login_content">
                <form>
                    <h1>Recuperar Senha</h1>
                    <div>
                        <input class="form-control" placeholder="Email" required="" />
                    </div>
                    <div>
                        <a class="btn btn-default submit" href="index.html">Enviar email de recuperação</a>
                        <a class="reset_pass" href="#signin">Voltar e fazer login.</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> TJ Desenvolvimento!</h1>
                            <p>©2017 All Rights Reserved. TJ Desenvolvimento! </p>
                        </div>
                    </div>
                </form>
            </section>
        </div>

        <div id="register" class="animate form registration_form">
            <section class="login_content">
                <form>
                    <h1>Create Account</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Username" required="" />
                    </div>
                    <div>
                        <input type="email" class="form-control" placeholder="Email" required="" />
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" required="" />
                    </div>
                    <div>
                        <a class="btn btn-default submit" href="index.html">Submit</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">Already a member ?
                            <a href="#signin" class="to_register"> Log in </a>
                        </p>

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                            <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded',function () {
        login.setLoginVariables();
    });
</script>