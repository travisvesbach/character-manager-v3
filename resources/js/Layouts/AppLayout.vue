<template>
    <div :class="classes">
        <div class="text-color">
            <Head :title="title" />

            <jet-banner />

            <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
                <nav class="bg-white border-b border-gray-100 dark:bg-black dark:border-black">
                    <!-- Primary Navigation Menu -->
                    <div class="mx-auto px-4">
                        <div class="flex justify-between h-10">
                            <div class="flex flex-grow">
                                <!-- Logo -->
                                <div class="flex-shrink-0 flex items-center">
                                    <Link :href="route('dashboard')">
                                        <jet-application-mark class="block h-5 w-auto" />
                                    </Link>
                                </div>

                                <!-- Header -->
                                <h2 class="font-semibold text-xl ml-5 flex items-center">
                                    <!-- {{ $inertia.page.props.appName }} -->
                                    <slot name="header"></slot>
                                </h2>

                                <!-- Navigation Links -->
                                <div class="hidden sm:-my-px sm:ml-10 sm:flex flex-grow items-center justify-end">
                                    <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                        Dashboard
                                    </jet-nav-link>
                                    <jet-nav-link :href="route('characters.index')" :active="route().current('characters*')" title="Characters">
                                        <!-- Characters -->
                                        <character-icon class="h-6 w-6"/>
                                    </jet-nav-link>
                                    <jet-nav-link :href="route('encounters.index')" :active="route().current('encounters*')" title="Encounters">
                                        <!-- Encounters -->
                                        <encounter-icon class="h-6 w-6"/>
                                    </jet-nav-link>
                                    <jet-nav-link :href="route('monsters.index')" :active="route().current('monsters*')" title="Monsters">
                                        <!-- Monsters -->
                                        <monster-icon class="h-6 w-6"/>
                                    </jet-nav-link>
                                    <flash v-bind:message="$page.props.flash.message" v-bind:status="$page.props.flash.status" v-bind:timestamp="$page.props.flash.timestamp"></flash>
                                </div>
                            </div>


                            <div class="hidden sm:flex sm:items-center">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <jet-dropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex flex link link-color">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                                <button type="button" class="flex link link-color">
                                                    {{ $page.props.user.name }}

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <dropdown-heading>Manage Account</dropdown-heading>

                                            <jet-dropdown-link :href="route('profile.show')">
                                                Profile
                                            </jet-dropdown-link>

                                            <dropdown-divider/>

                                            <!-- Admin -->
                                            <div v-if="$page.props.user.admin">
                                                <dropdown-heading>Admin</dropdown-heading>

                                                <jet-dropdown-link :href="route('users.index')">
                                                    Users
                                                </jet-dropdown-link>

                                                <dropdown-divider/>
                                            </div>

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <jet-dropdown-link as="button">
                                                    Log Out
                                                </jet-dropdown-link>
                                            </form>
                                        </template>
                                    </jet-dropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="flex link link-color">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                        <div class="pt-2 pb-3 space-y-1">
                            <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </jet-responsive-nav-link>

                            <flash v-bind:message="$page.props.flash.message" v-bind:status="$page.props.flash.status" v-bind:timestamp="$page.props.flash.timestamp"></flash>
                        </div>

                        <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                </div>

                                <div>
                                    <div class="font-medium text-base text-gray-800">{{ $page.props.user.name }}</div>
                                    <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}</div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                    Profile
                                </jet-responsive-nav-link>

                                <!-- Admin -->
                                <div v-if="$page.props.user.admin">
                                    <jet-responsive-nav-link :href="route('users.index')">
                                        Users
                                    </jet-responsive-nav-link>
                                </div>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <jet-responsive-nav-link as="button">
                                        Log Out
                                    </jet-responsive-nav-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
<!--                 <header class="bg-white shadow dark:bg-black"  v-if="this.$slots['header']">
                    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 text-xl heading-color">
                        <slot name="header"></slot>
                    </div>
                </header> -->

                <!-- subheader -->
                <div class="bg-white dark:bg-black">
                    <slot name="subheader"></slot>
                </div>

                <!-- Page Content -->
                <main>
                    <slot></slot>
                </main>

            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetBanner from '@/Jetstream/Banner.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import DropdownHeading from '@/Components/DropdownHeading';
    import DropdownDivider from '@/Components/DropdownDivider';
    import Flash from '@/Components/Flash'
    import EncounterIcon from '@/Components/Icons/Encounter'
    import MonsterIcon from '@/Components/Icons/Monster'
    import CharacterIcon from '@/Components/Icons/Character'

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
            DropdownHeading,
            DropdownDivider,
            Flash,
            EncounterIcon,
            MonsterIcon,
            CharacterIcon,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },
        computed: {
            classes() {
                let classes = [];
                classes.push(this.$page.props.user ? this.$page.props.user.theme : 'light');
                classes.push(this.$page.props.user && this.$page.props.user.font != 'default' ? this.$page.props.user.font : 'font-sans');

                return classes;
            }
        },
        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    })
</script>
