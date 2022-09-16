<template>
    <v-main>
        <div id="core-view">
            <v-fade-transition mode="out-in">
                <router-view />
            </v-fade-transition>
        </div>
    </v-main>
</template>

<style>
#core-view {
    padding-bottom: 100px;
}
</style>
