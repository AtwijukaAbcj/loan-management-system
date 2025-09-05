<form action="{{ route('borrower.destroy', $borrower->id) }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete Borrower</button>
</form>
