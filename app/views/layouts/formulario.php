<section class="form">
    <div class="form__container__topic">
        <div class="form__title">
            <h1>
                Como funciona nossa <span class="destaque"> análise!</span>
            </h1>
            <p>
                Em apenas três etapas, nossa equipe avalia sua necessidade e prepara uma proposta personalizada para a sua operação.
            </p>
        </div>
        <div class="form__topics">
            <div class="form__topic">
                <div class="form__topic__title">
                    <h2>1</h2>
                </div>
                <div class="form__text__topic">
                    <h2>Você envia seus dados!</h2>
                    <p>Preenche o formulário ao lado com as informações da sua empresa.</p>
                </div>
            </div>
            <div class="form__topic">
                <div class="form__topic__title">
                    <h2>2</h2>
                </div>
                <div class="form__text__topic">
                    <h2>Nosso time analisa sua operação!</h2>
                    <p>Avaliamos o porte e a necessidade da sua empresa.</p>
                </div>
            </div>
            <div class="form__topic" id="form">
                <div class="form__topic__title">
                    <h2>3</h2>
                </div>
                <div class="form__text__topic">
                    <h2>Você recebe uma proposta!</h2>
                    <p>Retorno em até 1 dia útil, direto no seu e-mail.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="form__container">
        <div class="form__container__title">
            <h1>
                Solicite um <span class="destaque">orçamento!</span>
            </h1>
            <p>
                Nossa equipe entra em contato em até 1 dia útil
            </p>
        </div>
        <div>
            <form class="form__inputs" method="POST" action="/sendForm">
                <div class="form__input">
                    <input class="inputFocus" type="text" name="nome" placeholder="Nome completo*" required>
                </div>
                <div class="form__input">
                    <input class="inputFocus" type="text" name="cnpj" placeholder="CNPJ da empresa*" required>
                </div>
                <div class="form__input">
                    <input class="inputFocus" type="email" name="email" placeholder="Email corporativo" required/>
                </div>
                <div class="form__line__input">
                    <input class="inputFocus" type="text" name="telefone" placeholder="Telefone*" />
                    <input class="inputFocus" type="text" name="colaboradores" placeholder="N° Colaboradores*"  />
                </div>
                <textarea class="form__input__mensage inputFocus" name="mensagem" placeholder="Mensagem"></textarea>
                <button class="mobile__cta" type="submit">
                    ENVIAR <i data-lucide="MoveRight"></i>
                </button>
            </form>
        </div>
    </div>
</section>