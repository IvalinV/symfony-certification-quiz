<template>
    <div class="container">
        <!-- Questions -->
        <template v-if="state.data">
            <h1>{{state.data.category}}</h1>
            <div v-for="(item, index) in state.data.questions" :key="index">
                <p>{{item.question}}</p>
                <ul style="list-style: none;" v-for="(answear, index) in item.answers" :key="index">
                    <li>
                        <span>
                            <input type="radio" name="answear" id="" @change="checkAnswear(answear.correct)">
                            {{answear.value}}
                        </span>
                    </li>
                </ul>
            </div>
        </template>
        <button class="btn btn-primary" @click="loadData('commands')">Next Category</button>
    </div>
</template>
<script setup>
    import {onMounted, ref} from 'vue';
    import axios from 'axios';

    defineProps({
        name: String,
    });

    const state = ref({
        data: {}
    });

    onMounted(async () => {
        loadData('architecture');
    })

    async function loadData(category){
        await axios.get(`/api/questions/topic/${category}`)
        .then(({data}) => {
            state.value.data = data;
        })
    }

    function checkAnswear(correct) {
        if(correct){
            alert('Correct!');
        }else{
            alert('Wrong!');
        }
    }
</script>