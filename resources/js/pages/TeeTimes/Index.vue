<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { Flag } from '@lucide/vue';
import BookingController from '@/actions/App/Http/Controllers/BookingController';
import LegacyBookingController from '@/actions/App/Http/Controllers/LegacyBookingController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { TeeTime } from '@/types/booking';

const props = defineProps<{
    teeTimes: TeeTime[];
}>();

const remaining = (teeTime: TeeTime): number => teeTime.capacity - (teeTime.bookings_count ?? 0);
</script>

<template>
    <Head title="Book a tee time" />

    <div class="flex flex-col space-y-6 p-4">
        <Heading
            title="Book a tee time"
            description="Every upcoming slot across every course, soonest first."
        />

        <Card v-for="teeTime in props.teeTimes" :key="teeTime.id" class="border-l-4 border-l-primary">
            <CardHeader class="flex-row items-center justify-between space-y-0">
                <CardTitle class="flex items-center gap-2">
                    <Flag class="size-4 shrink-0 text-primary" />
                    {{ teeTime.course?.name }}
                </CardTitle>
                <Badge :variant="remaining(teeTime) > 0 ? 'secondary' : 'destructive'">
                    {{ remaining(teeTime) > 0 ? `${remaining(teeTime)} spots left` : 'Full' }}
                </Badge>
            </CardHeader>
            <CardContent class="space-y-4 text-sm">
                <p class="text-muted-foreground">
                    {{ new Date(teeTime.starts_at).toLocaleString() }}
                </p>

                <div v-if="remaining(teeTime) > 0" class="grid gap-4 sm:grid-cols-2">
                    <Form
                        v-bind="BookingController.store.form(teeTime)"
                        class="flex items-end gap-2"
                        v-slot="{ errors, processing }"
                    >
                        <div class="grid gap-1.5">
                            <Label :for="`players-${teeTime.id}`">Players</Label>
                            <Input
                                :id="`players-${teeTime.id}`"
                                type="number"
                                name="players"
                                min="1"
                                max="4"
                                default-value="4"
                                class="w-20"
                            />
                            <InputError :message="errors.players" />
                        </div>
                        <Button :disabled="processing">Book (the Laravel way)</Button>
                    </Form>

                    <Form
                        v-bind="LegacyBookingController.store.form(teeTime)"
                        class="flex items-end gap-2"
                        v-slot="{ errors, processing }"
                    >
                        <div class="grid gap-1.5">
                            <Label :for="`legacy-players-${teeTime.id}`">Players</Label>
                            <Input
                                :id="`legacy-players-${teeTime.id}`"
                                type="number"
                                name="players"
                                min="1"
                                max="4"
                                default-value="4"
                                class="w-20"
                            />
                            <InputError :message="errors.players" />
                        </div>
                        <Button variant="outline" :disabled="processing">Book (the old way)</Button>
                    </Form>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
