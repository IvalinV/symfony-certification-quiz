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
        <button class="btn btn-primary" 
            @click="loadData(state.current_category_id - 1)"
            :disabled="state.current_category_id == state.categories[0].id"
        >
            Previous Category
        </button>
        <button class="btn btn-primary" 
            @click="loadData(state.current_category_id + 1)"
            :disabled="state.current_category_id == state.categories[state.categories.length - 1].id"
        >
            Next Category
        </button>
    </div>
</template>
<script setup>
    import {onMounted, ref} from 'vue';
    import axios from 'axios';

    defineProps({
        name: String,
    });

    const state = ref({
        data: {},
        categories: [
            {
                'id': 1,
                'slug': 'architecture'
            },
            {
                'id': 2,
                'slug': 'command-line'
            },
            {
                'id': 3,
                'slug': 'config'
            },
            {
                'id': 4,
                'slug': 'dependancy-injection'
            },
            {
                'id': 5,
                'slug': 'http-cache'
            },
            {
                'id': 6,
                'slug': 'automated-tests'
            },
        ],
        current_category_id: 1
    });

    onMounted(async () => {
        loadData();
    })

    async function loadData(id=null){
        if(id !== null){
            state.value.current_category_id = id;
        }
        let category = id !== null ? state.value.categories[id].slug: 'architecture';
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