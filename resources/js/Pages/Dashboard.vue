<template>
    
    <Head title="Open APIs Dashboard" />

    <div class="max-w-7xl m-auto rounded-md shadow p-4 mt-5 border">

        <div class="flex justify-start items-center gap-5">
            <h1 class="text-2xl inline-block">Public APIs</h1>
            <span>A list of publically available, free to use APIs</span>
        </div>

        <div class="mt-5">

            <table class="w-full border">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>API</th>
                        <th>Auth</th>
                        <th>HTTPS</th>
                        <th>Cors</th>
                        <th>Description</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <!-- Results -->

                </tbody>
            </table>

        </div>

    </div>

</template>

<script>

    import { Head, Link } from '@inertiajs/vue3';

    export default {
        props: {
            data: Object
        },
    };

</script>

