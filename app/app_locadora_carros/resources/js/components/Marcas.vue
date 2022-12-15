<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- inicio card buscas -->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                        placeholder="ID" v-model="busca.id">
                                </input-container-component>

                            </div>
                            <div class="col mb-3">

                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp"
                                    texto-ajuda="Opcional. Informe o nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp"
                                        placeholder="Nome da marca" v-model="busca.nome">
                                </input-container-component>

                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-end"
                            @click="pesquisar()">Pesquisar</button>
                    </template>

                </card-component>
                <!-- fim card buscas -->

                <!-- inicio card listagem de marcas -->
                <card-component titulo="Relacao de marcas">
                    <template v-slot:conteudo>
                        <table-component :dados="marcas.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar' }"
                            :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaAtualizar' }"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover' }"
                            :titulos="{
                                id: { titulo: 'ID', tipo: 'text' },
                                nome: { titulo: 'Nome', tipo: 'text' },
                                imagem: { titulo: 'Imagem', tipo: 'imagem' },
                                created_at: { titulo: 'Data de criação', tipo: 'data' },
                            }"></table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in marcas.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>

                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                                    data-bs-target="#modalMarca">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- fim card listagem de marcas -->
            </div>
        </div>

        <!-- inicio modal -->
        <!-- Button trigger modal -->

        <!-- Modal inclusao de marcas -->
        <modal-component id="modalMarca" titulo="Adicionar marca">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso."
                    v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes"
                    titulo="Erro ao tentar cadastrar esta marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp"
                        texto-ajuda="Informe o nome da marca">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                            v-model="nomeMarca" placeholder="Nome da marca">
                    </input-container-component>
                    
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp"
                        texto-ajuda="Selecione uma imagem">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp"
                            placeholder="Seleciona uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                    {{ arquivoImagem }}
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>

        </modal-component>
        <!-- fim Modal inclusao de marcas -->
        <!-- inicio Modal visualizar  marca -->
        <modal-component id="modalMarcaVisualizar" titulo="Visualizar marca">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>

                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

                <input-container-component titulo="Imagem">
                    <img :src="'/app_locadora_carros/public/storage/' + $store.state.item.imagem"
                        v-if="$store.state.item.imagem" alt="">
                </input-container-component>

                <input-container-component titulo="Data de criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>


            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- fim Modal visualizar  marca -->

        <!-- inicio Modal remoçao  marca -->
        <modal-component id="modalMarcaRemover" titulo="Remover marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso"
                    :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">

                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>


            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()"
                    v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>
        <!-- fim Modal remoção  marca -->

        <!-- Modal atualizacao de marcas -->
        <modal-component id="modalMarcaAtualizar" titulo="Atualizar marca">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso"
                    :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="novoNomeHelp"
                        texto-ajuda="Informe o nome da marca">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="novoNomeHelp"
                            v-model="$store.state.item.nome" placeholder="Nome da marca">
                    </input-container-component>

                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="novoImagemHelp"
                        texto-ajuda="Selecione uma imagem">
                        <input type="file" class="form-control-file" id="atualizarImagem"
                            aria-describedby="novoImagemHelp" placeholder="Seleciona uma imagem"
                            @change="carregarImagem($event)">
                    </input-container-component>
                </div>
                {{ $store.state.item.nome }}
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>

        </modal-component>
        <!-- fim Modal atualizacao de marcas -->

    </div>
</template>

<script>
export default {
 
    data() {
        return {
            urlbase: 'http://localhost/app_locadora_carros/public/api/v1/marca',
            urlPaginacao: '',
            urlFiltro: '',
            nomeMarca: '',
            arquivoImagem: [],
            transacaoStatus: '',
            transacaoDetalhes: {},
            marcas: {
                data: []
            },
            busca: {
                nome: '',
                id: ''
            }

        }
    },
    methods: {
        atualizar() {

            let url = this.urlbase + '/' + this.$store.state.item.id

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    
                }
            }

            let formData = new FormData();
            formData.append('_method', 'PATCH')
            formData.append('nome', this.$store.state.item.nome)
            if (this.arquivoImagem[0]) {
                formData.append('imagem', this.arquivoImagem[0])
            }

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro de marca atualizado com sucesso'
                    atualizarImagem.value = '';
                    this.carregarLista()
                })
                .catch(error => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = error.response.data.message
                    this.$store.state.transacao.dados = error.response.data.error
                })


        },
        remover() {

            let confirmacao = confirm('Tem certeza que deseja remover a marca?')
            if (!confirmacao) {
                return false;
            }

            let url = this.urlbase + '/' + this.$store.state.item.id

            let formData = new FormData();
            formData.append('_method', 'DELETE')

            // let config = {
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Authorization': this.token
            //     }
            // }



            axios.post(url, formData)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = response.data.msg

                    this.carregarLista()
                })
                .catch(error => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = error.response.data.error
                })

            console.log('chegmos aki  ')
        },

        pesquisar() {
            console.log(this.busca)
            let filtro = ''

            for (let chave in this.busca) {

                if (this.busca[chave]) {

                    if (filtro != '') {
                        filtro += ';'
                    }
                    filtro += chave + ':like:' + this.busca[chave]
                }

            }
            if (filtro != '') {
                this.urlPaginacao = 'page=1'
                this.urlFiltro = '&filtro=' + filtro
            } else {
                this.urlFiltro = ''
            }
            this.carregarLista()

        },

        paginacao(l) {
            if (l.url) {
                this.urlPaginacao = l.url.split('?')[1]

                this.carregarLista()
            }
        },
        carregarLista() {

            let url = this.urlbase + '?' + this.urlPaginacao + this.urlFiltro

            // let config = {
            //     headers: {
            //         'Accept': 'application/json',
            //         'Authorization': this.token
            //     }
            // }

            axios.get(url)
                .then(response => {
                    this.marcas = response.data
                    console.log(this.marcas)
                })
                .catch(error => {
                    console.log(error)
                })
        },

        carregarImagem(e) {
            this.arquivoImagem = e.target.files
        },
        salvar() {
            console.log(this.nomeMarca)
            console.log(this.arquivoImagem)
            let formData = new FormData();
            formData.append('nome', this.nomeMarca)
            formData.append('imagem', this.arquivoImagem[0])

            let config = {
                headers: {
                    'content-type': 'multipart/form-data',
       
                }
            }

            axios.post(this.urlbase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID:' + response.data.id
                    }
                    console.log(response)
                })
                .catch(error => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: 'Erro:' + error.response.data.message,
                        dados: error.response.data.errors
                    }
                    console.log(error.response.data.message)
                })
        }
    },
    mounted() {
        this.carregarLista()
    }

}
</script>
