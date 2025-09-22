@extends('layouts.admin')

@section('title', 'Import Employees')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-4 pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h3">Import Employees</h1>
            <p class="text-muted">Upload a CSV or Excel file to import multiple employees at once</p>
        </div>
        <div class="btn-toolbar">
            <div class="btn-group">
                <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Employees
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Import Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-upload me-2"></i>Upload Employee Data
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="import_file" class="form-label">
                                <strong>Select File</strong>
                            </label>
                            <input type="file" 
                                   class="form-control @error('import_file') is-invalid @enderror" 
                                   id="import_file" 
                                   name="import_file" 
                                   accept=".csv,.xlsx,.xls"
                                   required>
                            @error('import_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Supported formats: CSV, Excel (.xlsx, .xls). Maximum file size: 2MB
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary me-md-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Import Employees
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Instructions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>Import Instructions
                    </h6>
                </div>
                <div class="card-body">
                    <h6>File Format Requirements:</h6>
                    <ul class="mb-3">
                        <li>File must be in CSV or Excel format (.csv, .xlsx, .xls)</li>
                        <li>First row should contain column headers</li>
                        <li>Maximum file size: 2MB</li>
                        <li>All required fields must be present</li>
                    </ul>

                    <h6>Required Columns:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Column Name</th>
                                    <th>Description</th>
                                    <th>Example</th>
                                    <th>Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>employee_code</code></td>
                                    <td>Unique employee identifier</td>
                                    <td>EMP001</td>
                                    <td><span class="badge bg-danger">Yes</span></td>
                                </tr>
                                <tr>
                                    <td><code>name</code></td>
                                    <td>Full name of employee</td>
                                    <td>John Doe</td>
                                    <td><span class="badge bg-danger">Yes</span></td>
                                </tr>
                                <tr>
                                    <td><code>email</code></td>
                                    <td>Email address</td>
                                    <td>john@company.com</td>
                                    <td><span class="badge bg-danger">Yes</span></td>
                                </tr>
                                <tr>
                                    <td><code>phone</code></td>
                                    <td>Phone number</td>
                                    <td>+1234567890</td>
                                    <td><span class="badge bg-secondary">No</span></td>
                                </tr>
                                <tr>
                                    <td><code>department</code></td>
                                    <td>Department name</td>
                                    <td>IT</td>
                                    <td><span class="badge bg-danger">Yes</span></td>
                                </tr>
                                <tr>
                                    <td><code>position</code></td>
                                    <td>Job position</td>
                                    <td>Software Developer</td>
                                    <td><span class="badge bg-danger">Yes</span></td>
                                </tr>
                                <tr>
                                    <td><code>hire_date</code></td>
                                    <td>Hiring date</td>
                                    <td>2024-01-15</td>
                                    <td><span class="badge bg-danger">Yes</span></td>
                                </tr>
                                <tr>
                                    <td><code>status</code></td>
                                    <td>Employee status</td>
                                    <td>active or inactive</td>
                                    <td><span class="badge bg-danger">Yes</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> This import feature is currently under development. 
                        The file will be uploaded but actual import processing will be implemented in a future update.
                    </div>
                </div>
            </div>

            <!-- Sample Template -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-download me-2"></i>Download Sample Template
                    </h6>
                </div>
                <div class="card-body">
                    <p>Download a sample CSV template to ensure your data is formatted correctly:</p>
                    <button type="button" class="btn btn-success" onclick="downloadSampleTemplate()">
                        <i class="fas fa-download me-2"></i>Download Sample CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function downloadSampleTemplate() {
    // Create sample CSV content
    const csvContent = `employee_code,name,email,phone,department,position,hire_date,status
EMP001,John Doe,john.doe@company.com,+1234567890,IT,Software Developer,2024-01-15,active
EMP002,Jane Smith,jane.smith@company.com,+1234567891,HR,HR Manager,2024-01-10,active
EMP003,Bob Johnson,bob.johnson@company.com,+1234567892,Finance,Accountant,2024-01-20,active`;

    // Create and download file
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'employee_import_template.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>

@if(session('success'))
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Berhasil', @json(session('success')), 'success');
                } else {
                    alert(@json(session('success')));
                }
            }, 100);
        });
    </script>
@endif

@if(session('error'))
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Error', @json(session('error')), 'error');
                } else {
                    alert(@json(session('error')));
                }
            }, 100);
        });
    </script>
@endif
@endpush
