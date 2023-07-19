<template>
    <div class="container">
        <!-- Questions -->
        <template v-if="state.data">
            <h1>{{state.data.name}}</h1>
            <div v-for="(item, index) in state.data.questions" :key="index">
                <p>
                    {{item.description}}
                    <a :href="item.help" target="_blank">Help</a>
                </p>
                
                <ul style="list-style: none;" v-for="(answer, index) in item.answers" :key="index">
                    <li>
                        <span :style="getStyle(item, answer)">
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
        <button class="btn btn-primary" style="margin: 15px;"
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
    import {onMounted, ref, toRaw} from 'vue';
    import axios from 'axios';

    const props = defineProps({
        categories: Array
    });

    const state = ref({
        data: {},
        current_category_id: 1,
        has_answered: false,
        correct_answers_given: []
    });
    
    // a computed ref
    function hasMultpleAnswers(item){
        let multply = 
            toRaw(state.value.data.questions)
            .filter(q => q.answers.filter(a => a.correct).length > 1);

        return multply.find(q => q.description === item.description);
    }

    onMounted(async () => {
        loadData();
    })

    async function loadData(id=null){
        if(Object.keys(state.value.data).length){
            if(checkAnsweredQuestions()){
                confirm(`You gave ${state.value.correct_answers_given.length} correct answers`);
            }else{
                alert(`You did not answer all the questions`);
                return;
            }
        }
        
        if(id !== null){
            state.value.current_category_id = id;
        }

        let category = id !== null ? props.categories[id].slug: 'architecture';
        
        await axios.get(`/api/questions/topic/${category}`)
        .then(({data}) => {
            state.value.data = data;
            state.value.correct_answers_given = [];
        })
    }

    function checkanswer(question, answer, e) {
        answer.marked = true;

        if(answer.correct){
            state.value.correct_answers_given.push(answer);
        }

        let marked_answers = getAnswers(question, 'marked').length;
        let correct_answers = getAnswers(question, 'correct').length;

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

    function getStyle(item, answer){
        if(item.answered && answer.correct){
            return 'color:green';
        }
        else if(item.answered && !answer.correct){
            return 'color:red';
        }
        return '';
    }

    function checkAnsweredQuestions(){
        let answered = state.value.data.questions.filter(q => q.answered).length;
        let all = state.value.data.questions.length;

        if(answered == all){
            return true;
        }else{
            return false;
        }
    }
</script>