<?= $this->include('layouts/partials/header') ?>
<?= $this->include('modules/auth/login-style') ?>
<style>
    .code-input {
        letter-spacing: 5px;
        text-align: center;
        font-size: 1.5rem;
        width: 100%;
        max-width: 250px;
        margin: 20px auto;
        padding: 10px;
        border: 2px solid #007bff;
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .code-input:focus {
        border-color: #0056b3;
        outline: none;
    }

    .text-center {
        text-align: center;
    }

    .login-content {
        max-width: 400px;
    }
    .input-codigo{
        position: relative;
        margin: 25px 0;
        padding: 5px 0;
    }
</style>

<section>
    <img class="wave" src="<?= base_url('assets/images/wave2.png') ?>" />
    <div class="container">

        <div class="img img-welcome">
            <img src="<?= base_url('assets/images/welcome.svg') ?>" />
        </div>

        <div class="login-content">
            <form method="POST" action="<?= base_url('api/auth/doVerify2fa') ?>" class="form-login">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" />

                <?= $this->include('messages/msg-error') ?>
                <?= $this->include('messages/msg-success') ?>

                <h2 class="title-welcome">Verificación de Seguridad</h2>
                <p class="text-center" style="margin-bottom: 30px;">
                    Ingresa el código de 6 dígitos que enviamos a tu correo electrónico.
                </p>

                <div class="input-codigo one text-center">
                    <div class="div">
                        <input type="text" name="code" class="input code-input" placeholder="000000" minlength="6"
                            maxlength="6" pattern="\d{6}" required autofocus>
                    </div>
                </div>

                <button type="submit" class="button-login">Verificar Código</button>
            </form>
        </div>
    </div>
</section>

<?= $this->include('layouts/partials/footer') ?>