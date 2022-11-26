<template>
    <ModalUi :show="show">
        <h1 class="fs-4">Conheça</h1>
        <article>
            <p>
                Este sistema se utiliza de uma poderosa e conhecida biblioteca de ícones,
                o <a href="https://icons.getbootstrap.com" target="_blank"
                    title="Bootstrap Icons">
                    Bootstrap Icons</a>! Esta biblioteca possui quase 2.000 ícones e eles
                estão todos disponíveis
                para você!
            </p>
            <h1 class="fs-4">Como inserir?</h1>
            <p>
                Para inserir um ícone é simples! Você precisa obter a tag html do ícone e
                colar no campo de ícones no formulário. Se possui dúvidas, siga os passos
                abaixo:
            </p>
            <ol>
                <li>
                    Acesse <a href="https://icons.getbootstrap.com" target="_blank"
                        title="Bootstrap Icons"> https://icons.getbootstrap.com</a>
                </li>
                <li>
                    Então você poderá navegar entre os milhares de ícones existentes. Você
                    pode facilmente
                    encontrar um ícone utilizando o campo de filtragem. Clique sobre o
                    ícone
                    escolhido.
                </li>
                <li>
                    Na página do ícone à direita(em desktop) você terá diversas formas de
                    obter este ícone, dentre elas a opção <strong>Icon font</strong>.
                    Copie o
                    código HTML indicado.
                </li>
                <li>
                    Volte para este painel e cole o código obtido no campo
                    <strong>Ícone</strong> e então <strong>salve as alterações</strong>.
                </li>
                <li>
                    Pronto! Você já inseriu um ícone para o seu link ou botão.
                </li>
            </ol>
        </article>
    </ModalUi>
</template>

<script>

import ModalUi from '../Ui/ModalUi.vue';

export default {
    components: { ModalUi },

    props: {
        show: { type: Boolean, default: false }
    },
};

</script>