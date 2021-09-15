<template>
    <div>
        <h1> I will show how all other component react to changes</h1>
        Current state of counter is : {{ counter }}
        <div>
            <com-a></com-a>
            <com-b></com-b>
            <com-c></com-c>
            <div>
                <Button @click="changeCounter">Click change the state of the counter</Button>
            </div>
        </div>
    </div>
</template>


<script>
import ComA from './ComA';
import ComB from './ComB';
import ComC from './ComC';
import {mapGetters, mapActions} from "vuex";
export default {
    data() {
        return {
            localVar : "some value"
        }
    },

    computed: {
      ...mapGetters( {
          counter: 'getCounter'
      }),

    },

    methods: {
        ...mapActions([
            'changeCounterByAction'
        ]),

        changeCounter() {
            this.$store.dispatch('changeCounterByAction', 1)
            // this.$store.commit('changeCounter', 1);
        },

        runSomeThingWhenCounterChange() {
            this.localVar = "hihi do ngok oi";
            console.log('i am running based on each change happening');
        }
    },

    created() {
        console.log(this.$store.state.counter);
    },

    components: {
        ComA,
        ComB,
        ComC,
    },

    watch: {
        counter(value) {
            console.log('counter is changing', value);
            this.runSomeThingWhenCounterChange();
            console.log('local var', this.localVar);
        }
    }


}
</script>
