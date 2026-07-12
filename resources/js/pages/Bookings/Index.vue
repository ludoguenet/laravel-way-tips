<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Flag } from '@lucide/vue';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { show, showLegacy } from '@/routes/bookings';
import { index as teeTimesIndex } from '@/routes/tee-times';
import type { Booking } from '@/types/booking';

defineProps<{
    bookings: Booking[];
}>();
</script>

<template>
    <Head title="Your bookings" />

    <div class="flex flex-col space-y-6 p-4">
        <Heading
            title="Your bookings"
            description="Every tee time you've reserved, newest first."
        />

        <Link :href="teeTimesIndex().url" class="text-sm text-primary underline-offset-4 hover:underline">
            Book another tee time &rarr;
        </Link>

        <div v-if="bookings.length === 0" class="text-sm text-muted-foreground">
            You haven't booked a tee time yet.
        </div>

        <Card
            v-for="booking in bookings"
            :key="booking.id"
            class="border-l-4 border-l-primary"
        >
            <CardHeader class="flex-row items-center justify-between space-y-0">
                <div class="flex items-start gap-2">
                    <Flag class="mt-0.5 size-4 shrink-0 text-primary" />
                    <div>
                        <CardTitle>{{ booking.tee_time?.course?.name }}</CardTitle>
                        <p class="text-sm text-muted-foreground">
                            {{ new Date(booking.tee_time!.starts_at).toLocaleString() }}
                            &middot; {{ booking.players }} players
                        </p>
                    </div>
                </div>
                <Badge v-if="booking.cancelled_at" variant="destructive">Cancelled</Badge>
            </CardHeader>
            <CardContent class="flex items-center gap-4 text-sm">
                <Link
                    :href="show(booking).url"
                    class="font-medium text-primary underline-offset-4 hover:underline"
                >
                    View (the Laravel way)
                </Link>
                <Link
                    :href="showLegacy(booking.id).url"
                    class="text-muted-foreground underline-offset-4 hover:underline"
                >
                    View (the old way)
                </Link>
            </CardContent>
        </Card>
    </div>
</template>
