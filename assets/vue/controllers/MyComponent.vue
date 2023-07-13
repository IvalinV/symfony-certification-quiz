<template>
    <div class="container">
        <!-- Questions -->
        <template v-if="state.data">
            <h1>{{state.data.category}}</h1>
            <div v-for="(item, index) in state.data.questions" :key="index">
                <p>{{item.question}}</p>
                <ul style="list-style: none;" v-for="(answer, index) in item.answers" :key="index">
                    <li>
                        <span :style="[item.answered ? answer.style : '']">
                            <input 
                                :type="hasMultpleAnswers(item) ? 'checkbox':'radio'" 
                                name="answer"
                                @change="checkanswer(item, answer, $event)"
                            >
                            {{answer.value}}
                        </span>
                    </li>
                </ul>
            </div>
        </template>
        <button class="btn btn-primary" 
            @click="loadData(state.current_category_id - 1)"
            :disabled="state.current_category_id == categories[0].id"
        >
            Previous Category
        </button>
        <button class="btn btn-primary" 
            @click="loadData(state.current_category_id + 1)"
            :disabled="state.current_category_id == categories[categories.length - 1].id"
        >
            Next Category
        </button>
    </div>
</template>
<script setup>
    import {onMounted, computed, ref, toRaw} from 'vue';
    import axios from 'axios';

    const props = defineProps({
        categories: Array
    });

    const state = ref({
        data: {},
        current_category_id: 1,
        has_answered: false,
    });
    
    // a computed ref
    function hasMultpleAnswers(item){
       let multply = 
            toRaw(state.value.data.questions)
            .filter(q => q.answers.filter(a => a.correct).length > 1);
        return multply.find(q => q.question === item.question);
    }

    onMounted(async () => {
        loadData();
    })

    async function loadData(id=null){
        if(id !== null){
            state.value.current_category_id = id;
        }
        let category = id !== null ? props.categories[id].slug: 'architecture';
        await axios.get(`/api/questions/topic/${category}`)
        .then(({data}) => {
            state.value.data = data;
        })
    }

    function checkanswer(question, answer, e) {
        answer.marked = true;

        let marked_answers = getAnswers(question, 'marked').length;
        let correct_answers = getAnswers(question, 'correct').length;
        console.log(marked_answers)
        
        if(marked_answers == correct_answers){
            question.answered = true;
        }else{
            e.preventDefault();
            return;
        }
    }

    function getAnswers(question, param){
        return toRaw(question.answers).filter(a => a[param]);
    }
</script>