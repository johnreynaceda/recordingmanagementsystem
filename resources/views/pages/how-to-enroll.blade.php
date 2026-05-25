@section('title', 'How to Enroll')
<x-home-layout>
    <section class="relative -mx-4 -mt-4 overflow-hidden bg-slate-950 md:-mx-6 md:-mt-6">
        <img src="{{ asset('images/bg.jpg') }}" alt="TMCNHS enrollment"
            class="absolute inset-0 h-full w-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-main/75"></div>

        <div class="relative mx-auto grid min-h-[30rem] max-w-7xl items-end gap-10 px-4 pb-12 pt-24 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8 lg:pb-16">
            <div class="max-w-3xl text-white">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-red-200">Admissions Guide</p>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    How to Enroll
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                    Prepare the correct documents before enrollment opens so the school can verify learner identity, eligibility, and previous grade completion without delay.
                </p>
            </div>

            <div class="rounded-2xl border border-white/15 bg-white/10 p-5 text-white shadow-2xl backdrop-blur">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white text-main shadow-lg">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-100">Enrollment Reminder</p>
                        <h2 class="mt-1 text-2xl font-bold">Submit complete and accurate documents</h2>
                    </div>
                </div>
                <div class="mt-6 space-y-3 text-sm leading-6 text-slate-100">
                    <p>Birth certificates are submitted once throughout a learner's stay in basic education.</p>
                    <p>Temporary secondary documents may be accepted when the PSA/NSO birth certificate is not yet available.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-14 sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 text-main">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-slate-950">Enrollment Schedule</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Enrollment shall be conducted one week before the official start and opening of classes, or as directed by the Department.
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 text-main">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-slate-950">Learner Eligibility</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        All learners shall be accepted in basic education, following existing rules that establish learner identity and eligibility.
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 text-main">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 104 11c0 1.22-.103 2.416-.3 3.584" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-slate-950">Confidential Records</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Collected documents shall be treated with utmost confidentiality and aligned with Data Privacy provisions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <aside class="lg:sticky lg:top-28">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-main">Document Checklist</p>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">What to prepare</h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">
                        The school follows DepEd guidance on enrollment documents. Bring original or accepted supporting documents when applicable.
                    </p>

                    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                            <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-slate-700">Grade 7</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                                <thead class="bg-white text-xs font-bold uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Eligibility</th>
                                        <th scope="col" class="px-4 py-3">Required Document</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    <tr>
                                        <td class="px-4 py-4 font-medium">Grade 6 Graduate or Grade 6 Candidate for Graduation</td>
                                        <td class="px-4 py-4">SF 9, formerly Form 138, Grade 6 Report Card</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 font-medium">PEPT Passer or A&E Elementary Certification Passer</td>
                                        <td class="px-4 py-4">
                                            PEPT or A&E Certificate of Rating, Presentation of Portfolio Assessment Certificate, and PSA/NSO Birth Certificate or accepted secondary document
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                            <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-slate-700">Grades 8-10 and Transferees</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                                <thead class="bg-white text-xs font-bold uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Learner Type</th>
                                        <th scope="col" class="px-4 py-3">Eligibility</th>
                                        <th scope="col" class="px-4 py-3">Required Document</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    <tr>
                                        <td class="px-4 py-4 font-bold text-main">Grade 7</td>
                                        <td class="px-4 py-4 font-medium">Grade 6 Graduate</td>
                                        <td class="px-4 py-4">Grade 6 SF 9, Report Card</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 font-bold text-main">Grade 7</td>
                                        <td class="px-4 py-4 font-medium">PEPT Passer or A&E Elementary Certification Passer</td>
                                        <td class="px-4 py-4">PEPT or A&E Certificate of Rating / PPA Certificate</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 font-bold text-main">Grades 8-10</td>
                                        <td class="px-4 py-4 font-medium">Completion of the last grade level attended</td>
                                        <td class="px-4 py-4">SF 9, Report Card, of the last grade level completed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </aside>

                <div class="space-y-8">
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-main text-sm font-bold text-white">1</span>
                            <div>
                                <h3 class="text-xl font-bold text-slate-950">Follow the announced enrollment schedule</h3>
                                <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                                    The enrollment period shall be conducted one week before the official start and opening of classes or as directed by the Department. Further, DepEd shall issue supporting memoranda providing specific activities and schedules concerning enrollment.
                                </p>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-main text-sm font-bold text-white">2</span>
                            <div>
                                <h3 class="text-xl font-bold text-slate-950">Prepare eligibility and identity documents</h3>
                                <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                                    This order adheres to the fact that all learners shall be accepted in basic education. Public and private schools, ALS CLCs, SUCs, and LUCs offering basic education programs shall adhere to existing rules that govern eligibility standards to establish the identity of learners.
                                </p>
                                <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                                    All learners shall only submit a Birth Certificate once throughout their stay in basic education from K to 12. If the learner's PSA/NSO birth certificate is not yet available, secondary documents may be submitted upon enrollment, provided that the birth certificate will be submitted once available.
                                </p>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-950">Accepted secondary documents</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">National ID or any primary government ID, such as driver's license, passport, or postal ID</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">Certificate of Live Birth from the Local Civil Registry</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">Marriage Certificate</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">PhilHealth ID</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">PWD ID</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">Barangay certification establishing the child's identity, including name, date of birth, sex, and parents' names</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">Affidavit of undertaking executed by parents</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700">NSO or PSA Certificate of Foundling, when the learner is determined to be a foundling</div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 text-sm font-medium text-slate-700 sm:col-span-2">Baptismal Certificate</div>
                        </div>
                        <p class="mt-5 text-justify text-base leading-8 text-slate-700">
                            In cases where the PSA/NSO-issued birth certificate is not available at the time of enrollment, any secondary document may be submitted until October 31 of the current school year, as the accuracy of the learner's information is vital for official enrollment data in DepEd.
                        </p>
                    </article>

                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-main text-sm font-bold text-white">3</span>
                            <div>
                                <h3 class="text-xl font-bold text-slate-950">Additional requirement for transferees</h3>
                                <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                                    Learners from public or private schools in the Philippines who will transfer shall submit their SF 9, or Report Card, signed by the School Head, or a letter certifying the last grade level the learner completed, signed by the School Registrar. Refer to DO 54, s. 2016 for guidelines on the request and transfer of the learner's school records.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>
