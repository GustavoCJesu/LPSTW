<section class="form" id="form">
    <div class="form__container__topic">
        <div class="form__title">
            <h2 class="section-heading">
                Como funciona nossa <span class="destaque"> análise!</span>
            </h2>
            <p>
                Em apenas três etapas, nossa equipe avalia sua necessidade e prepara uma proposta personalizada para a sua operação.
            </p>
        </div>
        <div class="form__topics">
            <div class="form__topic">
                <div class="form__topic__title">
                    <h3>1</h3>
                </div>
                <div class="form__text__topic">
                    <h3>Você envia seus dados!</h3>
                    <p>Preencha o formulário ao lado com as informações da sua empresa.</p>
                </div>
            </div>
            <div class="form__topic">
                <div class="form__topic__title">
                    <h3>2</h3>
                </div>
                <div class="form__text__topic">
                    <h3>Nosso time analisa sua operação!</h3>
                    <p>Avaliamos o porte e a necessidade da sua empresa.</p>
                </div>
            </div>
            <div class="form__topic" id="form">
                <div class="form__topic__title">
                    <h3>3</h3>
                </div>
                <div class="form__text__topic">
                    <h3>Você recebe uma proposta!</h3>
                    <p>Retorno em até 1 dia útil, direto no seu e-mail.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="form__container">
        <div class="form__container__title">
            <h2 class="section-heading">
                Solicite um <span class="destaque">orçamento!</span>
            </h2>
            <p>
                Nossa equipe entra em contato em até 1 dia útil
            </p>
            
        </div>
        <div>
            <form class="form__inputs" id="leadForm">
                <div class="form__input">
                    <input class="inputFocus" id="nome" type="text" name="nome" placeholder="Nome completo*" required>
                </div>
                <div class="form__input">
                    <input class="inputFocus" id="cnpj" type="text" name="cnpj" placeholder="CNPJ da empresa*" required>
                </div>
                <div class="form__input">
                    <input class="inputFocus" id="email" type="email" name="email" placeholder="Email corporativo*" required/>
                </div>
                <div class="form__line__input">
                    <input class="inputFocus" id="telefone" type="text" name="telefone" placeholder="Telefone" />
                    <input class="inputFocus" id="colaboradores" type="text" name="colaboradores" placeholder="N° Colaboradores" />
                </div>
                <textarea class="form__input__mensage inputFocus" id="mensage" name="mensagem" placeholder="Mensagem"></textarea>
                <span class="form__obs">(*) indicam uma informação obrigatória.</span>
                <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($_ENV['SITE_KEY']) ?>"></div>
                <button class="mobile__cta" type="submit">
                    ENVIAR <i data-lucide="MoveRight"></i>
                </button>
            </form>
        </div>
    </div>
</section>