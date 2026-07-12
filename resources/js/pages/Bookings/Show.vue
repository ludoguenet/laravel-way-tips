<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { Flag } from '@lucide/vue';
import BookingCancellationController from '@/actions/App/Http/Controllers/BookingCancellationController';
import BookingTransferController from '@/actions/App/Http/Controllers/BookingTransferController';
import LegacyBookingCancellationController from '@/actions/App/Http/Controllers/LegacyBookingCancellationController';
import LegacyBookingTransferController from '@/actions/App/Http/Controllers/LegacyBookingTransferController';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { index, ownership, ownershipLegacy } from '@/routes/bookings';
import type { Booking } from '@/types/booking';
import type { Golfer } from '@/types/role';

const props = defineProps<{
    booking: Booking;
    otherGolfers: Pick<Golfer, 'id' | 'name'>[];
    servedBy: string;
}>();
</script>

<template>
    <Head :title="`Booking #${props.booking.id}`" />

    <div class="flex flex-col space-y-6 p-4">
        <Heading
            title="Booking details"
            :description="`Reservation #${props.booking.id}`"
        />

        <div class="rounded-lg border border-dashed p-3 font-mono text-xs text-muted-foreground">
            served by: {{ props.servedBy }}
        </div>

        <Card class="border-l-4 border-l-primary">
            <CardHeader class="flex-row items-center justify-between space-y-0">
                <CardTitle class="flex items-center gap-2">
                    <Flag class="size-4 shrink-0 text-primary" />
                    {{ props.booking.tee_time?.course?.name }}
                </CardTitle>
                <Badge v-if="props.booking.cancelled_at" variant="destructive">Cancelled</Badge>
            </CardHeader>
            <CardContent class="space-y-2 text-sm">
                <p>
                    <span class="text-muted-foreground">Tee time:</span>
                    {{ new Date(props.booking.tee_time!.starts_at).toLocaleString() }}
                </p>
                <p>
                    <span class="text-muted-foreground">Course:</span>
                    {{ props.booking.tee_time?.course?.name }}
                    ({{ props.booking.tee_time?.course?.holes }} holes,
                    {{ props.booking.tee_time?.course?.city }})
                </p>
                <p>
                    <span class="text-muted-foreground">Players:</span>
                    {{ props.booking.players }}
                </p>
                <p>
                    <span class="text-muted-foreground">Golfer:</span>
                    {{ props.booking.golfer?.name }} ({{ props.booking.golfer?.email }})
                </p>
            </CardContent>
        </Card>

        <div class="flex flex-wrap items-center gap-4 text-sm">
            <Link
                :href="ownership(props.booking).url"
                class="font-medium text-primary underline-offset-4 hover:underline"
            >
                Check ownership (the Laravel way)
            </Link>
            <Link
                :href="ownershipLegacy(props.booking).url"
                class="text-muted-foreground underline-offset-4 hover:underline"
            >
                Check ownership (the old way)
            </Link>
        </div>

        <div v-if="!props.booking.cancelled_at" class="flex flex-wrap items-center gap-2">
            <Form v-bind="BookingCancellationController.store.form(props.booking)" v-slot="{ processing }">
                <Button variant="destructive" :disabled="processing">Cancel (the Laravel way)</Button>
            </Form>
            <Form v-bind="LegacyBookingCancellationController.store.form(props.booking)" v-slot="{ processing }">
                <Button variant="outline" :disabled="processing">Cancel (the old way)</Button>
            </Form>
        </div>

        <div v-if="props.otherGolfers.length" class="flex flex-wrap items-end gap-4">
            <Form v-bind="BookingTransferController.store.form(props.booking)" v-slot="{ processing }" class="flex items-end gap-2">
                <select name="golfer_id" class="h-9 rounded-md border bg-background px-2 text-sm">
                    <option v-for="golfer in props.otherGolfers" :key="golfer.id" :value="golfer.id">
                        {{ golfer.name }}
                    </option>
                </select>
                <Button :disabled="processing">Transfer (the Laravel way)</Button>
            </Form>
            <Form v-bind="LegacyBookingTransferController.store.form(props.booking)" v-slot="{ processing }" class="flex items-end gap-2">
                <select name="golfer_id" class="h-9 rounded-md border bg-background px-2 text-sm">
                    <option v-for="golfer in props.otherGolfers" :key="golfer.id" :value="golfer.id">
                        {{ golfer.name }}
                    </option>
                </select>
                <Button variant="outline" :disabled="processing">Transfer (the old way)</Button>
            </Form>
        </div>

        <Link :href="index().url" class="text-sm text-primary underline-offset-4 hover:underline">
            &larr; Back to your bookings
        </Link>
    </div>
</template>
