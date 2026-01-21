<dialog id="my_modal_4" class="modal">
    <div class="modal-box bg-white px-6 py-5">
        <h3 class="font-bold text-lg">Create Project</h3>

        <form method="POST" class="mt-4 space-y-4">
            @csrf

            <div>
                <label class="label">
                    <span class="label-text">Project Name</span>
                </label>
                <input type="text" name="name" required class="input input-bordered w-full">
            </div>

            <div>
                <label class="label">
                    <span class="label-text">Description</span>
                </label>
                <textarea rows="3" name="description" class="textarea textarea-bordered w-full"></textarea>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Create</button>
                <form method="dialog">
                    <button class="btn btn-ghost">Cancel</button>
                </form>
            </div>
        </form>
    </div>
</dialog>
