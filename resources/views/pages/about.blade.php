@section('title', 'About Us')
<x-home-layout>
    <section class="relative -mx-4 -mt-4 overflow-hidden bg-slate-950 md:-mx-6 md:-mt-6">
        <img src="{{ asset('images/bg.jpg') }}" alt="Trece Martires City National High School"
            class="absolute inset-0 h-full w-full object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-main/70"></div>

        <div class="relative mx-auto grid min-h-[32rem] max-w-7xl items-end gap-10 px-4 pb-12 pt-24 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:px-8 lg:pb-16">
            <div class="max-w-3xl text-white">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-red-200">School History</p>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    Then and Now
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                    The story of Trece Martires City National High School began with borrowed rooms, shared books, and a community that believed the city deserved its own strong public secondary school.
                </p>
            </div>

            <div class="rounded-2xl border border-white/15 bg-white/10 p-5 text-white shadow-2xl backdrop-blur">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/tmcnhs_logo.png') }}" alt="TMCNHS logo"
                        class="h-20 w-20 rounded-2xl bg-white p-2 shadow-lg">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-100">TMCNHS</p>
                        <h2 class="mt-1 text-2xl font-bold">Trece Martires City National High School</h2>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                    <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-4">
                        <p class="text-2xl font-extrabold">1966</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-200">Founded</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-4">
                        <p class="text-2xl font-extrabold">1983</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-200">Nationalized</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-4">
                        <p class="text-2xl font-extrabold">25k</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-200">Sq. meters</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-14 sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-main">Location</p>
                    <p class="mt-3 text-lg font-bold text-slate-900">Heart of Trece Martires City</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">A few meters from the Provincial Capitol and at the center of Cavite Province.</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-main">Programs</p>
                    <p class="mt-3 text-lg font-bold text-slate-900">STE, SPA, ALS, and General Curriculum</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Specialized and inclusive pathways for different learner strengths and circumstances.</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-main">Tagline</p>
                    <p class="mt-3 text-lg font-bold text-slate-900">We stand, We smile, We serve</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">A school community committed to service, growth, and holistic learner development.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 border-b border-slate-200 pb-8">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-main">About Us</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 sm:text-4xl">School History: Then and Now</h2>
                <p class="mt-4 max-w-3xl text-base leading-7 text-slate-600">
                    From a junior high school in a borrowed elementary compound to the biggest secondary school in the district, TMCNHS continues to grow with the support of its learners, teachers, administrators, stakeholders, and the wider Trece Martires community.
                </p>
            </div>

            <div class="space-y-8">
                <article class="relative border-l-4 border-main pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-main shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-main">July 6, 1966</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">The first light of dawn</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        It was July 6, 1966 when Trece Martires City Junior High School saw the first light of dawn. The creation of this school was approved by the Secretary of Education and Culture through proper channels by means of a petition by parents and a resolution of the City Council of Trece Martires. The sponsor of the resolution was Governor Delfin N. Montano, Ex-Officio City Mayor, and the people who supported the founding were Miss Diosdada Tiongco, Mrs. Lutgarda P. Morabe, Mr. Dioscorro Sugatan, Chief of Police Melencio de Sagun Sr., and all the barrio captains at that time. Since there was no available school site, this high school had to contain itself in the Trece Martires City Elementary School compound. TMCES shared some of its spare classrooms for their secondary students. The very accommodating District Supervisor also acted as the Assistant Principal of Tanza High School, TMCJHS' mother school. The District Supervisor of Tanza II with office in TMCES was Diosdada Tiongco, now a leading citizen of Trece Martires City.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">After Two Years</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Becoming Trece Martires City High School</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        After two years of being a Junior High School, it became Trece Martires City High School. Aside from having no school site, it also had no library of its own. The teachers as well as students were allowed to share with the library of the elementary school, whose property custodian was Mrs. Lutgarda P. Morabe, who was then the Principal of TMCES. Books were only a handful and some textbooks were in the custody of the class advisers who lent them to students. They only had a property custodian to account for these books at the end of every school year. This situation prevailed for quite a time. The time came for the high school to change its course of life. A very young and energetic man came to teach in this school, fresh from college, a cum laude of San Sebastian College, Cavite. Fate declared that this young man would lead the poor school to some height.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">June 2, 1980 and February 18, 1983</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">A leader's ambition for a school site</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        This young, energetic, talented, and ambitious man was no other than Mr. Roman M. Salazar, a legitimate Treceño. From an ordinary classroom teacher, he rose to become a head teacher on June 2, 1980. His ambition for his hometown and for the high school was to have its own school site and be there as soon as possible. He tried to battle the giants in Sangguniang Panlungsod to fight for the school. Because of his eloquence and intelligence, he was able to defend Resolution 7-83 on February 18, 1983, as sponsored by City Coordinator Mr. Francisco Luna through the request of the TMCHS Principal, to transfer the high school to its own site. This gave birth to Trece Martires City High School, with the site allocated for it near the Capitol Building.
                    </p>
                </article>

                <article class="relative border-l-4 border-main pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-main shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-main">June 24, 1983</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Conversion into a national high school</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        On June 24, 1983, under BP Blg. 599, an act converting the Trece Martires City High School in the City of Trece Martires into a National High School and providing funds therefore was enacted at the Batasang Pambansa on April 14, 1983 and approved by President Ferdinand E. Marcos on the aforesaid date. Thus, the school has operated as national up to the present time. Trece Martires City National High School is located at the heart of the city, a few meters away from the Provincial Capitol. The site is flat and has an area of 25,000 square meters, which was acquired through donations as approved under Resolution No. 7-83 dated February 18, 1983.
                    </p>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Trece Martires City was inaugurated as Provincial Capital on January 1, 1956, on the same day Governor Montano was sworn into office as Cavite's Provincial Governor and Trece Martires City's Ex-Officio Mayor. Trece Martires City became the provincial capital in three stages. First, under Republic Act No. 981, the city comprised a territory not exceeding one thousand hectares, located near the intersection of the Tanza-Indang road and the Naic-Dasmariñas road. Second, on June 22, 1957, the original act was amended by Republic Act 1912, increasing this territory. Third, consequently, the municipalities of Indang and General Trias had to yield their respective areas to this territorial expansion.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">April 7, 1959 and City Context</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">The city at the center of Cavite</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Finally, Republic Act 2139 was approved on April 7, 1959, in which the Congress of the Philippines gave Trece Martires City administrative jurisdiction over land along and including four national roads from Tanza, Indang Matanda, and Cruses Dams, stretching its territorial limits by ten kilometers all around. Trece Martires City is located at the center of Cavite Province. It is bounded on the north by the municipality of Tanza and on the south by the municipalities of Naic and Tanza. It is 45 kilometers from Metro Manila, 25 kilometers from Cavite City, 23 kilometers from Tagaytay City, and 26.3 kilometers from Puerto Azul in Ternate.
                    </p>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        The city has 79 registered schools with complete basic facilities, 15 public day care centers, 25 public elementary schools, 4 public secondary schools, and 35 private schools. Only 15 schools offered complete secondary education. There is an existing training center, the Technical Skills and Development Authority (TESDA), a vocational school for those who are unable to avail or afford college education.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">Growth and Extensions</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">The biggest secondary school in the district</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Trece Martires City National High School is located at the center of the city. It is the biggest secondary school in the district. It is also classified as an exceptional school having a specialized curriculum in Science, Technology, and Engineering (STE) and a Special Program in the Arts (SPA). Since the City of Trece Martires has become a residential site, the population of school-aged children continuously increased. Year after year, the student and teacher population has grown in line with the continued development of the municipality.
                    </p>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        TMCNHS, with the assistance of the LGU, opened three extensions located in different barangays, namely TMCNHS-Cabuco Extension, TMCNHS-Sunshine Ville Extension, and TMCNHS-Hugo Perez Annex. Currently, all these annexes are under the supervision of Dr. Magdaleno R. Lubigan, with the help of designated Officers-In-Charge.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">2012 to SY 2015-2016</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Curriculum upgrades</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Apparently, the population increased and the curriculum upgraded. In 2012, the Science Curriculum opened two sections for Grade 7 to Grade 10. The Special Program in the Arts was started in SY 2015-2016, aiming to develop students who have skills or inclination in theater arts, dancing, music, visual arts, and multimedia arts. Currently, the General Curriculum, SPA, and Science Curriculum comprise 22 sections in Grade 7, 23 sections in Grade 8, 21 sections in Grade 9, and 22 sections in Grade 10.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">Alternative Learning System</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">A second chance education program</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Furthermore, TMCNHS expanded its vision by catering to the Alternative Learning System (ALS), a parallel learning system in the Philippines that provides opportunities for out-of-school youth and adult (OSYA) learners to develop basic and functional literacy skills and to access equivalent pathways to complete basic education. A viable alternative to the existing formal education system, ALS encompasses both non-formal and informal sources of knowledge and skills. As a second chance education program, it aims to empower OSYA learners to continue learning in a manner, time, and place suitable to their preferences and circumstances, and for them to achieve their goals of improving their quality of life and becoming productive contributors to society.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">2023 Manpower</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">A strong academic community</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Having efficient and highly knowledgeable academic school heads, department heads, supportive office staff, and competent teachers, TMCNHS has established outstanding performance in the scholastic community. TMCNHS-Main manpower has 201 teaching personnel and 17 administrative and support staff gearing on the first month of 2023.
                    </p>
                </article>

                <article class="relative border-l-4 border-slate-200 pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-slate-400 shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">SY 2022-2023</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Learners, facilities, and stakeholder support</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Subsequently, following its basic aspirations to develop holistic learners, the school caters to 5,833 enrollees for school year 2022-2023 and expects more numbers in the coming school year. Today, the TMCNHS family is looking forward to well-developed infrastructures like conducive classrooms, computer and science laboratories, student centers, a well-built audio visual room, conference rooms, dance room, music room, a school clinic, and especially well-designed comfort rooms that can be utilized by every learner. The development and improvement within the institution are made possible through the support and cooperation of its stakeholders.
                    </p>
                </article>

                <article class="relative border-l-4 border-main pl-6">
                    <span class="absolute -left-[0.65rem] top-1 h-5 w-5 rounded-full border-4 border-white bg-main shadow"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-main">Today</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Aligned with DepEd's mantra</h3>
                    <p class="mt-3 text-justify text-base leading-8 text-slate-700">
                        Lastly, all the projects and programs implemented by TMCNHS are aligned and supported by the Division Office. This enables the school to provide a congruent educational goal to support the Department of Education's mantra: "Batang Makabansa: Bansang Makabata." Along with the TMCNHS tagline, "We stand, We smile, We serve," this institution highly aims for the best.
                    </p>
                </article>
            </div>
        </div>
    </section>
</x-home-layout>
