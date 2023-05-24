@fragment('download')
    <a href="{{$file_path ?? ""}}" download="{{$file_name ?? ""}}" class="btn btn-primary btn-lg p-0">
        <span class="d-block py-1 px-4">Download Rom</span>
    </a><br>
    <a href="{{$spoiler_file_path ?? ""}}" download="{{$spoiler_file_name ?? ""}}" class="btn btn-primary btn-lg p-0">
        <span class="d-block py-1 px-4">Download Spoiler Log</span>
    </a>
    <br>
    <span class="btn btn-secondary" data-bs-dismiss="modal" class="d-block py-1 px-4">Close</span>
@endfragment
@fragment('error')
    <p class="text-black">
        <strong class="text-black">The uploaded ROM is not supported.</strong><br>
        This randomizer requires a Lufia 2 (NA-SNES) rom with the MD5 hash listed below. The 'Lufia 2 Fixxxer Deluxe' version is also supported; vanilla Lufia 2 roms will automatically be patched with the 'Fixxxer Deluxe' patch.<br>
        <br>
        6efc477d6203ed2b3b9133c1cd9e9c5d (NA)<br>
        026b649ed316448e038349e39a6fe579 (Fixxxer)<br>
        b58c76f2ac0b2aeb9b779e880d2bff18 (Frue)<br>
        <br>
        <span class="btn btn-secondary" data-bs-dismiss="modal" class="d-block py-1 px-4">Close</span>
    </p>
@endfragment
