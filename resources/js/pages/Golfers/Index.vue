<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import GolferRoleController from '@/actions/App/Http/Controllers/GolferRoleController';
import LegacyGolferRoleController from '@/actions/App/Http/Controllers/LegacyGolferRoleController';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { index as golferBookings, indexLegacy as golferBookingsLegacy } from '@/routes/golfers/bookings';
import type { Golfer, Role } from '@/types/role';

const props = defineProps<{
    golfers: Golfer[];
    roles: Role[];
}>();

const unassignedRoles = (golfer: Golfer): Role[] => {
    const assignedIds = new Set(golfer.roles.map((role) => role.id));

    return props.roles.filter((role) => !assignedIds.has(role.id));
};
</script>

<template>
    <Head title="Golfers" />

    <div class="flex flex-col space-y-6 p-4">
        <Heading title="Golfers" description="Manage staff roles for the pro shop." />

        <Card v-for="golfer in props.golfers" :key="golfer.id">
            <CardHeader class="flex-row items-center justify-between space-y-0">
                <div>
                    <CardTitle>{{ golfer.name }}</CardTitle>
                    <p class="text-sm text-muted-foreground">{{ golfer.email }}</p>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <Link
                        :href="golferBookings(golfer).url"
                        class="font-medium text-primary underline-offset-4 hover:underline"
                    >
                        Bookings (the Laravel way)
                    </Link>
                    <Link
                        :href="golferBookingsLegacy(golfer).url"
                        class="text-muted-foreground underline-offset-4 hover:underline"
                    >
                        Bookings (the old way)
                    </Link>
                </div>
            </CardHeader>
            <CardContent class="space-y-4 text-sm">
                <div v-if="golfer.roles.length" class="flex flex-wrap items-center gap-2">
                    <div
                        v-for="role in golfer.roles"
                        :key="role.id"
                        class="flex items-center gap-2 rounded-md border border-l-4 border-l-primary p-2"
                    >
                        <Badge variant="secondary">{{ role.name }}</Badge>
                        <span class="text-xs text-muted-foreground">
                            since {{ role.pivot?.assigned_at ? new Date(role.pivot.assigned_at).toLocaleDateString() : 'unknown' }}
                        </span>
                        <Form
                            v-bind="GolferRoleController.update.form({ golfer: golfer.id, role: role.id })"
                            v-slot="{ processing }"
                        >
                            <Button size="sm" variant="outline" :disabled="processing">
                                Renew (the Laravel way)
                            </Button>
                        </Form>
                        <Form
                            v-bind="LegacyGolferRoleController.update.form({ golfer: golfer.id, role: role.id })"
                            v-slot="{ processing }"
                        >
                            <Button size="sm" variant="ghost" :disabled="processing">
                                Renew (the old way)
                            </Button>
                        </Form>
                    </div>
                </div>
                <p v-else class="text-muted-foreground">No staff roles assigned.</p>

                <div v-if="unassignedRoles(golfer).length" class="flex flex-wrap items-center gap-2">
                    <Form
                        v-for="role in unassignedRoles(golfer)"
                        :key="role.id"
                        v-bind="GolferRoleController.store.form(golfer)"
                        v-slot="{ processing }"
                    >
                        <input type="hidden" name="role_id" :value="role.id" />
                        <Button size="sm" :disabled="processing">
                            Assign {{ role.name }} (the Laravel way)
                        </Button>
                    </Form>
                    <Form
                        v-for="role in unassignedRoles(golfer)"
                        :key="`legacy-${role.id}`"
                        v-bind="LegacyGolferRoleController.store.form(golfer)"
                        v-slot="{ processing }"
                    >
                        <input type="hidden" name="role_id" :value="role.id" />
                        <Button size="sm" variant="outline" :disabled="processing">
                            Assign {{ role.name }} (the old way)
                        </Button>
                    </Form>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
