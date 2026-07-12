<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Flag } from '@lucide/vue';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { index as golfersIndex } from '@/routes/golfers';
import type { Booking } from '@/types/booking';
import type { Golfer } from '@/types/role';

const props = defineProps<{
    golfer: Golfer;
    bookings: Booking[];
    servedBy: string;
}>();
</script>

<template>
    <Head :title="`${props.golfer.name}'s bookings`" />

    <div class="flex flex-col space-y-6 p-4">
        <Heading
            :title="`${props.golfer.name}'s bookings`"
            :description="props.golfer.email"
        />

        <div class="rounded-lg border border-dashed p-3 font-mono text-xs text-muted-foreground">
            served by: {{ props.servedBy }}
        </div>

        <div v-if="props.bookings.length === 0" class="text-sm text-muted-foreground">
            No bookings for this golfer.
        </div>

        <Card v-for="booking in props.bookings" :key="booking.id" class="border-l-4 border-l-primary">
            <CardHeader class="flex-row items-center justify-between space-y-0">
                <CardTitle class="flex items-center gap-2">
                    <Flag class="size-4 shrink-0 text-primary" />
                    {{ booking.tee_time?.course?.name }}
                </CardTitle>
                <Badge v-if="booking.cancelled_at" variant="destructive">Cancelled</Badge>
            </CardHeader>
            <CardContent class="text-sm text-muted-foreground">
                {{ new Date(booking.tee_time!.starts_at).toLocaleString() }}
                &middot; {{ booking.players }} players
            </CardContent>
        </Card>

        <Link :href="golfersIndex().url" class="text-sm text-primary underline-offset-4 hover:underline">
            &larr; Back to golfers
        </Link>
    </div>
</template>
