<div class="container">
    <h1>View Borrower</h1>
    <form>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <label>First Name</label>
                <input type="text" class="form-control" value="{{ $borrower->first_name }}" disabled>
            </div>
            <div>
                <label>Last Name</label>
                <input type="text" class="form-control" value="{{ $borrower->last_name }}" disabled>
            </div>
            <div>
                <label>Full Name</label>
                <input type="text" class="form-control" value="{{ $borrower->full_name }}" disabled>
            </div>
            <div>
                <label>Gender</label>
                <input type="text" class="form-control" value="{{ $borrower->gender }}" disabled>
            </div>
            <div>
                <label>Date of Birth</label>
                <input type="text" class="form-control" value="{{ $borrower->date_of_birth }}" disabled>
            </div>
            <div>
                <label>Occupation</label>
                <input type="text" class="form-control" value="{{ $borrower->occupation }}" disabled>
            </div>
            <div>
                <label>National ID</label>
                <input type="text" class="form-control" value="{{ $borrower->national_id }}" disabled>
            </div>
            <div>
                <label>Phone</label>
                <input type="text" class="form-control" value="{{ $borrower->phone }}" disabled>
            </div>
            <div>
                <label>Email</label>
                <input type="text" class="form-control" value="{{ $borrower->email }}" disabled>
            </div>
            <div style="grid-column: 1 / span 2;">
                <label>Address</label>
                <input type="text" class="form-control" value="{{ $borrower->address }}" disabled>
            </div>
        </div>
    </form>
</div>
