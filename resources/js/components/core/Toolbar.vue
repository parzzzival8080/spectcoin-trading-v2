<template>
    <v-app-bar
        app
        id="core-toolbar"
        color="teal darken-3"
        dark
        hide-on-scroll
        scroll-target="#scrolling-techniques-4"
    >
        <v-app-bar-nav-icon
            v-if="responsive"
            class="default v-btn--simple"
            dark
            icon
            @click.stop="onClickBtn"
        ></v-app-bar-nav-icon>
        <v-toolbar-title class="white--text font-weight-light">
            FCKain
        </v-toolbar-title>
        <v-spacer />
        <!-- <v-toolbar-items>
            <v-row class="align-center">
                <router-link
                    v-ripple
                    class="toolbar-items"
                    to="/admin/dashboard"
                >
                    <v-icon color="tertiary">mdi-view-dashboard</v-icon>
                </router-link>
                <v-menu
                    bottom
                    left
                    content-class="dropdown-menu"
                    offset-y
                    transition="slide-y-transition"
                >
                    <template v-slot:activator="{ on }">
                        <router-link
                            v-ripple
                            v-on="on"
                            class="toolbar-items"
                            to="/admin/notifications"
                        >
                            <v-badge color="error" overlap>
                                <template slot="badge">
                                    {{ notifications.length }}
                                </template>
                                <v-icon color="tertiary">mdi-bell</v-icon>
                            </v-badge>
                        </router-link>
                    </template>
                    <v-card>
                        <v-list dense>
                            <v-list-tile
                                v-for="notification in notifications"
                                :key="notification"
                                @click="onClick"
                            >
                                <v-list-tile-title v-text="notification" />
                            </v-list-tile>
                        </v-list>
                    </v-card>
                </v-menu>
                <router-link
                    v-ripple
                    class="toolbar-items"
                    to="/admin/user-profile"
                >
                    <v-icon color="tertiary">mdi-account</v-icon>
                </router-link>
            </v-row>
        </v-toolbar-items> -->
    </v-app-bar>
</template>

<script>
import { mapMutations } from "vuex";

export default {
    data: () => ({
        notifications: [
            "Mike, John responded to your email",
            "You have 5 new tasks",
            "You're now a friend with Andrew",
            "Another Notification",
            "Another One"
        ],
        title: null,
        responsive: false
    }),

    watch: {
        $route(val) {
            this.title = val.name;
        }
    },

    mounted() {
        this.onResponsiveInverted();
        window.addEventListener("resize", this.onResponsiveInverted);
    },
    beforeDestroy() {
        window.removeEventListener("resize", this.onResponsiveInverted);
    },

    methods: {
        ...mapMutations("app", ["setDrawer", "toggleDrawer"]),
        onClickBtn() {
            this.setDrawer(!this.$store.state.app.drawer);
        },
        onClick() {
            //
        },
        onResponsiveInverted() {
            if (window.innerWidth < 991) {
                this.responsive = true;
            } else {
                this.responsive = false;
            }
        }
    }
};
</script>

<style>
#core-toolbar a {
    text-decoration: none;
}
</style>
