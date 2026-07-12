<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { show } from '@/routes/bookings';
import type { Booking } from '@/types/booking';

const props = defineProps<{
    booking: Booking;
    owns: boolean;
    servedBy: string;
}>();
</script>

<template>
    <Head :title="`Ownership check — booking #${props.booking.id}`" />

    <div class="flex flex-col space-y-6 p-4">
        <Heading
            title="Ownership check"
            :description="`Does the current golfer own booking #${props.booking.id}?`"
        />

        <div class="rounded-lg border border-dashed p-3 font-mono text-xs text-muted-foreground">
            served by: {{ props.servedBy }}
        </div>

        <Badge :variant="props.owns ? 'secondary' : 'destructive'" class="w-fit text-sm">
            {{ props.owns ? 'Owns this booking' : 'Does not own this booking' }}
        </Badge>

        <Link :href="show(props.booking).url" class="text-sm text-primary underline-offset-4 hover:underline">
            &larr; Back to the booking
        </Link>
    </div>
</template>
