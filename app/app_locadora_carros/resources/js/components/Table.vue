<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
                    <th v-if="(visualizar.visivel || atualizar.visivel || remover.visivel)"></th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'text'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="('/app_locadora_carros/public/storage/' + valor)" width="30">
                        </span>
                    </td>
                    <td v-if="(visualizar.visivel || atualizar.visivel || remover.visivel)">
                        <button class="btn btn-outline-primary btn-sm" v-if="visualizar.visivel" :data-bs-toggle="visualizar.dataToggle" :data-bs-target="visualizar.dataTarget" @click="setStore(obj)" >Visualizar</button>
                        <button class="btn btn-outline-success btn-sm" v-if="atualizar.visivel" :data-bs-toggle="atualizar.dataToggle" :data-bs-target="atualizar.dataTarget"  @click="setStore(obj)" >Atualizar</button>
                        <button class="btn btn-outline-danger btn-sm" v-if="remover.visivel" :data-bs-toggle="remover.dataToggle" :data-bs-target="remover.dataTarget" @click="setStore(obj)" >Remover</button>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</template>

<script>
export default {
    props: ['dados', 'titulos' , 'atualizar' , 'visualizar' , 'remover'],
    methods:{
        setStore(obj){
            this.$store.state.transacao.status = '';
            this.$store.state.transacao.mensagem = '';
            this.$store.state.item = obj
            
        }

    },
    computed: {
        dadosFiltrados() {

            let campos = Object.keys(this.titulos)
            let dadosFiltrado = []

            this.dados.map((item, chave) => {

                let itemFiltrado = {}

                campos.forEach(campo => {
                    itemFiltrado[campo] = item[campo]
                })
                dadosFiltrado.push(itemFiltrado)
            })
            return dadosFiltrado
        }
    }
}
</script>
