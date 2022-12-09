<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
                    <th v-if="(visualizar.visivel || atualizar || remover)"></th>

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
                    <td v-if="(visualizar.visivel || atualizar || remover)">
                        <button class="btn btn-outline-primary btn-sm" v-if="visualizar.visivel" :data-bs-toggle="visualizar.dataToggle" :data-bs-target="visualizar.dataTarget" >Visualizar</button>
                        <button class="btn btn-outline-success btn-sm" v-if="atualizar" >Atualizar</button>
                        <button class="btn btn-outline-danger btn-sm" v-if="remover" >Remover</button>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</template>

<script>
export default {
    props: ['dados', 'titulos' , 'atualizar' , 'visualizar' , 'remover'],
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
