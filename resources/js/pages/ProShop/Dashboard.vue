<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Flag } from '@lucide/vue';
import Heading from '@/components/Heading.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { Booking } from '@/types/booking';

const props = defineProps<{
    bookings: Booking[];
    servedBy: string;
}>();
</script>

<template>
    <Head title="Pro shop dashboard" />

    <div class="flex flex-col space-y-6 p-4">
        <Heading title="Pro shop dashboard" description="Every booking on the books for today." />

        <div class="rounded-lg border border-dashed p-3 font-mono text-xs text-muted-foreground">
            served by: {{ props.servedBy }}
        </div>

        <div v-if="props.bookings.length === 0" class="text-sm text-muted-foreground">
            No bookings today.
        </div>

        <Card v-for="booking in props.bookings" :key="booking.id" class="border-l-4 border-l-primary">
            <CardHeader class="flex-row items-center justify-between space-y-0">
                <CardTitle class="flex items-center gap-2">
                    <Flag class="size-4 shrink-0 text-primary" />
                    {{ booking.tee_time?.course?.name }}
                </CardTitle>
            </CardHeader>
            <CardContent class="text-sm text-muted-foreground">
                {{ new Date(booking.tee_time!.starts_at).toLocaleTimeString() }}
                &middot; {{ booking.golfer?.name }} &middot; {{ booking.players }} players
            </CardContent>
        </Card>
    </div>
</template>
