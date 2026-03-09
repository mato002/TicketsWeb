@extends('layouts.app')

@section('title', 'M-Pesa Debug')

@section('content')
<div class="container">
    <h1>M-Pesa Debug Tool</h1>
    <button onclick="testMpesa()">Test M-Pesa</button>
    <pre id="results"></pre>
</div>

<script>
async function testMpesa() {
    const results = document.getElementById('results');
    results.textContent = 'Testing...';
    
    try {
        const response = await fetch('/debug/mpesa/test');
        const data = await response.json();
        results.textContent = JSON.stringify(data, null, 2);
    } catch (error) {
        results.textContent = 'Error: ' + error.message;
    }
}
</script>
@endsection
