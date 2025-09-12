@extends('layouts.app')

@section('title', 'Scoring Rubric Configuration')

@section('content')
<div class="rubric-main-container" x-data="rubricTabs()">
    <div class="rubric-content">
        <!-- Back Button -->
        <div class="rubric-header-nav">
            <a href="{{ route('admin.profile') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <h2 class="rubric-main-title">Scoring Rubric Configuration</h2>

        <!-- Tabs Navigation -->
        <div class="tab-nav mb-3">
            <button class="btn" :class="tab === 'leadership' ? 'btn-disable' : ''" @click="tab = 'leadership'">I. Leadership Excellence</button>
            <button class="btn" :class="tab === 'academic' ? 'btn-disable' : ''" @click="tab = 'academic'">II. Academic Excellence</button>
            <button class="btn" :class="tab === 'awards' ? 'btn-disable' : ''" @click="tab = 'awards'">III. Awards/Recognition</button>
            <button class="btn" :class="tab === 'community' ? 'btn-disable' : ''" @click="tab = 'community'">IV. Community Involvement</button>
            <button class="btn" :class="tab === 'conduct' ? 'btn-disable' : ''" @click="tab = 'conduct'">V. Good Conduct</button>
        </div>

        <!-- Tab Content -->
        <template x-if="tab === 'leadership'">
            @include('admin.rubrics.sections.leadership')
        </template>
        <template x-if="tab === 'academic'">
            @include('admin.rubrics.sections.academic')
        </template>
        <template x-if="tab === 'awards'">
            @include('admin.rubrics.sections.awards')
        </template>
        <template x-if="tab === 'community'">
            @include('admin.rubrics.sections.community')
        </template>
        <template x-if="tab === 'conduct'">
            @include('admin.rubrics.sections.conduct')
        </template>

        <!-- Navigation Buttons -->
        <div class="unified-pagination mt-4">
            <button class="btn-nav" @click="previousTab()" x-show="!isFirstTab()" type="button">
                <i class="fas fa-chevron-left"></i> Previous
            </button>
            <button class="btn-nav" @click="nextTab()" x-show="!isLastTab()" type="button">
                Next <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function rubricTabs() {
    const tabs = ['leadership', 'academic', 'awards', 'community', 'conduct'];
    
    return {
        tab: 'leadership', // default active
        tabs: tabs,
        
        nextTab() {
            const currentIndex = this.tabs.indexOf(this.tab);
            if (currentIndex < this.tabs.length - 1) {
                this.tab = this.tabs[currentIndex + 1];
            }
        },
        
        previousTab() {
            const currentIndex = this.tabs.indexOf(this.tab);
            if (currentIndex > 0) {
                this.tab = this.tabs[currentIndex - 1];
            }
        },
        
        isFirstTab() {
            return this.tab === this.tabs[0];
        },
        
        isLastTab() {
            return this.tab === this.tabs[this.tabs.length - 1];
        }
    }
}
</script>
@endsection
