import Dashboard from "./components/dashboard.vue";
import Appointments from "./components/appointments/Lists.vue";
import Users from './components/users/Lists.vue'
import UpdateSetting from './components/settings/UpdateSetting.vue'
import UpdateProfile from './components/profiles/UpdateProfile.vue'
import Create from "./components/appointments/create.vue";

export default [
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard
    },
    {
        path: '/admin/appointments',
        name: 'admin.appointments',
        component: Appointments,
    },
    {
        path: '/admin/appointments/create',
        name: 'admin.appointment.create',
        component: Create
    },
    {
        path: '/admin/users',
        name: 'admin.users',
        component: Users
    },
    {
        path: '/admin/settings',
        name: 'admin.settings',
        component: UpdateSetting
    },
    {
        path: '/admin/profiles',
        name: 'admin.profiles',
        component: UpdateProfile
    }
]
