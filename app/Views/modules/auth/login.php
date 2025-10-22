<?= $this->include('layouts/partials/header') ?>

<?= $this->include('modules/auth/login-style') ?>

<section>
    <img class="wave" src="<?= base_url('assets/images/wave2.png') ?>" />
    <div class="container">

        <div class="img img-welcome">
            <img src="<?= base_url('assets/images/welcome.svg') ?>" />
        </div>

        <div class="login-content">
            <form method="POST" action="<?= base_url('api/auth/doLogin') ?>" class="form-login">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" />

                <?= $this->include('messages/msg-error') ?>
                <?= $this->include('messages/msg-success') ?>

                <h2 class="title-welcome">Bienvenido</h2>

                <div class="input-div one">
                    <div class="icon-login">
                        <i data-lucide="user"></i>
                    </div>
                    <div class="div">
                        <input type="text" name="username" class="input" placeholder="Username" minlength="4"
                            maxlength="70" value="<?= set_value('username') ?>" required>
                    </div>
                </div>

                <div class="input-div pass">
                    <div class="icon-login">
                        <i data-lucide="lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" id="password" name="password" class="input" placeholder="Contraseña"
                            pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$"
                            title="La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un carácter especial"
                            required>
                    </div>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i data-lucide="eye"></i>
                    </button>
                </div>

                <button type="submit" class="button-login">Ingresar</button>
            </form>
        </div>
    </div>
</section>


<?= $this->include('layouts/partials/footer') ?>
<script src="<?= base_url('js/shared/inputs/showPassInput.js') ?>"></script>