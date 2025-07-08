<x-layout>
    <x-page-heading>Register</x-page-heading>

    <x-forms.form method="POST" action="/register" enctype="multipart/form-data">
        <x-forms.input label="Your Name" name="name"/>
        <x-forms.input label="Email" name="email" type="email"/>
        <x-forms.input label="Password" name="password" type="password"/>
        <x-forms.input label="Password Confirmation" name="password_confirmation" type="password"/>
        <x-forms.divider/>

        <x-forms.input label="Profile Logo" name="logo" type="file"/>

        {{-- Select Dropdown for User Type --}}
        <x-forms.select label="User Type" name="user_type">
            <option value="employer">Employer</option>
            <option value="job_seeker">Job Seeker</option>
        </x-forms.select>

        <x-forms.input label="Bio (optional)" name="bio"/>

        <x-forms.button>Create Account</x-forms.button>
    </x-forms.form>
</x-layout>
