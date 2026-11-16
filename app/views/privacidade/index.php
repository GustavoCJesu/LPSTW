<?php
$pagina = 'privacidade';
$pageTitle = 'Política de Privacidade | STW - Safe to Work';
$pageDescription = 'Saiba quais dados a STW coleta pelo site, para que usamos, com quem compartilhamos e como exercer seus direitos previstos na LGPD.';
$pagePath = '/politica-de-privacidade';
$pageStyles = ['/css/privacidade.css'];

require_once __DIR__ . '/../layouts/head.php';
require_once __DIR__ . '/../layouts/header.php';
?>
<main class="privacidade">
    <article class="privacidade__conteudo">
        <header class="privacidade__topo">
            <h1>Política de <span class="destaque">Privacidade</span></h1>
            <p class="privacidade__data">Última atualização: 16 de novembro de 2026</p>
            <p>
                Esta política explica como a STW trata os dados pessoais enviados por este site,
                de acordo com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018 — LGPD).
            </p>
        </header>

        <section>
            <h2>1. Quem somos</h2>
            <p>
                Este site é da STW — Safe to Work, solução de gestão de EPIs da ASW Presvida.
                Somos os responsáveis (controladores) pelos dados pessoais enviados por aqui.
                Para qualquer assunto sobre privacidade, fale com a gente em
                <a href="mailto:contato@stw.com.br">contato@stw.com.br</a>.
            </p>
        </section>

        <section>
            <h2>2. Quais dados coletamos</h2>
            <ul>
                <li>
                    <strong>Dados que você informa no formulário de orçamento:</strong> nome, e-mail,
                    telefone, CNPJ da empresa, número de colaboradores e a mensagem que você escrever.
                </li>
                <li>
                    <strong>Dados públicos da empresa:</strong> a partir do CNPJ informado, consultamos a base
                    pública da Receita Federal (por meio da BrasilAPI) para obter dados cadastrais, como razão
                    social, endereço, atividade econômica e quadro de sócios e administradores.
                </li>
                <li>
                    <strong>Dados técnicos:</strong> para evitar spam, o formulário usa o Google reCAPTCHA,
                    que analisa informações do navegador e o endereço IP. O servidor de hospedagem também
                    registra dados de acesso, como IP, data e hora, por motivos de segurança.
                </li>
            </ul>
        </section>

        <section>
            <h2>3. Para que usamos</h2>
            <ul>
                <li>Responder à sua solicitação e preparar uma proposta comercial;</li>
                <li>Entrar em contato pelo e-mail ou telefone informados para tratar dessa proposta;</li>
                <li>Entender o porte e a atividade da empresa para indicar a solução adequada;</li>
                <li>Proteger o site contra spam, fraudes e abusos.</li>
            </ul>
            <p>Não vendemos seus dados e não os usamos para outras finalidades sem avisar você.</p>
        </section>

        <section>
            <h2>4. Base legal</h2>
            <p>
                Tratamos esses dados com base no legítimo interesse (art. 7º, IX, da LGPD), para atender
                à solicitação que você mesmo nos enviou e para manter o site seguro. Os dados da empresa
                obtidos pelo CNPJ são de acesso público e usados apenas para essa mesma finalidade.
            </p>
        </section>

        <section>
            <h2>5. Com quem compartilhamos</h2>
            <ul>
                <li><strong>Trello (Atlassian):</strong> ferramenta em que nossa equipe organiza as solicitações recebidas;</li>
                <li><strong>Google (reCAPTCHA):</strong> verificação contra spam;</li>
                <li><strong>BrasilAPI:</strong> recebe apenas o CNPJ informado, para consultar os dados públicos da empresa;</li>
                <li><strong>Empresa de hospedagem:</strong> onde o site e seus registros de acesso ficam armazenados;</li>
                <li><strong>Autoridades públicas:</strong> somente quando exigido por lei ou ordem judicial.</li>
            </ul>
            <p>
                Alguns desses fornecedores, como Trello e Google, podem armazenar dados em servidores
                fora do Brasil.
            </p>
        </section>

        <section>
            <h2>6. Por quanto tempo guardamos</h2>
            <p>
                Guardamos os dados enquanto forem necessários para atender à sua solicitação e conduzir
                a negociação. Depois disso, eles são excluídos ou anonimizados, exceto quando a lei
                exigir que sejam mantidos por mais tempo.
            </p>
        </section>

        <section>
            <h2>7. Seus direitos</h2>
            <p>Pela LGPD (art. 18), você pode, a qualquer momento:</p>
            <ul>
                <li>Confirmar se tratamos seus dados e ter acesso a eles;</li>
                <li>Corrigir dados incompletos, inexatos ou desatualizados;</li>
                <li>Pedir a anonimização, o bloqueio ou a eliminação de dados desnecessários ou excessivos;</li>
                <li>Pedir a portabilidade dos dados a outro fornecedor;</li>
                <li>Saber com quem compartilhamos seus dados;</li>
                <li>Se opor ao tratamento e pedir a eliminação dos seus dados.</li>
            </ul>
            <p>
                Para exercer qualquer um desses direitos, escreva para
                <a href="mailto:contato@stw.com.br">contato@stw.com.br</a>. Você também pode apresentar
                uma reclamação à Autoridade Nacional de Proteção de Dados (ANPD).
            </p>
        </section>

        <section>
            <h2>8. Cookies</h2>
            <p>
                Este site não usa cookies próprios de publicidade ou de análise de audiência. O Google
                reCAPTCHA pode usar cookies para funcionar. Se adicionarmos ferramentas de análise no
                futuro, esta política será atualizada e pediremos seu consentimento quando necessário.
            </p>
        </section>

        <section>
            <h2>9. Segurança</h2>
            <p>
                Adotamos medidas técnicas e administrativas para proteger os dados contra acessos não
                autorizados, perda ou uso indevido, e restringimos o acesso às solicitações recebidas
                à equipe responsável pelo atendimento.
            </p>
        </section>

        <section>
            <h2>10. Alterações nesta política</h2>
            <p>
                Podemos atualizar esta política para refletir mudanças no site ou na legislação.
                A versão vigente fica sempre nesta página, com a data da última atualização.
            </p>
        </section>

        <a class="privacidade__voltar" href="/">← Voltar para o site</a>
    </article>
</main>
<?php
require_once __DIR__ . '/../layouts/footer.php';
